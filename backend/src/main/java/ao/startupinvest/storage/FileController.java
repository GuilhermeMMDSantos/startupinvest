package ao.startupinvest.storage;

import ao.startupinvest.common.exception.ApiException;
import org.springframework.core.io.Resource;
import org.springframework.core.io.UrlResource;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import java.net.MalformedURLException;
import java.nio.file.Path;

/**
 * Serves uploaded documents (pitch decks, ID docs, verification videos).
 * All access requires authentication; fine-grained ownership checks live in the
 * feature controllers that hand out these paths (investor/startup/admin).
 */
@RestController
@RequestMapping("/api/files")
public class FileController {

    private final FileStorageService fileStorageService;

    public FileController(FileStorageService fileStorageService) {
        this.fileStorageService = fileStorageService;
    }

    @GetMapping
    public ResponseEntity<Resource> get(@RequestParam("path") String path) {
        if (path.contains("..")) {
            throw ApiException.badRequest("Caminho inválido");
        }
        try {
            Path resolved = fileStorageService.resolve(path);
            Resource resource = new UrlResource(resolved.toUri());
            if (!resource.exists() || !resource.isReadable()) {
                throw ApiException.notFound("Ficheiro não encontrado");
            }
            return ResponseEntity.ok().body(resource);
        } catch (MalformedURLException e) {
            throw new ApiException(HttpStatus.INTERNAL_SERVER_ERROR, "Erro ao ler ficheiro");
        }
    }
}
