package ao.startupinvest.scoring;

import java.math.BigDecimal;
import java.util.function.Function;

record MetricDefinition(String key, String displayName, double weight, double min, double max,
                         boolean higherIsBetter, Function<StartupAssessment, BigDecimal> extractor) {

    double rawValue(StartupAssessment a) {
        BigDecimal v = extractor.apply(a);
        return v == null ? 0.0 : v.doubleValue();
    }
}
