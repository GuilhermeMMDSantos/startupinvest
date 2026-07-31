package ao.startupinvest.storage;

import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.config.AppProperties;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.StandardCopyOption;
import java.util.List;
import java.util.Set;
import java.util.UUID;


import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@Service
@RequiredArgsConstructor
public class FileStorageService {

    private static final Logger debug = LoggerFactory.getLogger(FileStorageService.class);

    private static final Set<String> ALLOWED_EXTENSIONS = Set.of(
            "pdf", "png", "jpg", "jpeg", "mp4", "mov", "webm", "ppt", "pptx"
    );
    private static final long MAX_SIZE_BYTES = 150L * 1024 * 1024;

    private final AppProperties appProperties;

    public String store(MultipartFile file, String subFolder) {
        if (file == null || file.isEmpty()) {
            throw ApiException.badRequest("Ficheiro em falta");
        }
        if (file.getSize() > MAX_SIZE_BYTES) {
            throw ApiException.badRequest("Ficheiro excede o tamanho máximo permitido (150MB)");
        }
        String original = file.getOriginalFilename() != null ? file.getOriginalFilename() : "ficheiro";
        String extension = "";
        int dot = original.lastIndexOf('.');
        if (dot >= 0) {
            extension = original.substring(dot + 1).toLowerCase();
        }
        if (!ALLOWED_EXTENSIONS.contains(extension)) {
            throw ApiException.badRequest("Tipo de ficheiro não permitido: " + extension);
        }

        try {
            
            Path folder = Path.of(appProperties.getStorage().getRoot(), subFolder);
            
            Files.createDirectories(folder);
            
            String filename = UUID.randomUUID() + "." + extension;
            Path target = folder.resolve(filename);
           
            Files.copy(file.getInputStream(), target, StandardCopyOption.REPLACE_EXISTING);
           
            return subFolder + "/" + filename;
        } catch (IOException e) {
            throw new ApiException(org.springframework.http.HttpStatus.INTERNAL_SERVER_ERROR,
                    "Falha ao guardar ficheiro: " + e.getMessage());
        }
    }

    public Path resolve(String relativePath) {
        return Path.of(appProperties.getStorage().getRoot(), relativePath).normalize();
    }
}
