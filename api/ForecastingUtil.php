<?php

/**
 * Utility class for advanced statistical forecasting.
 */
class ForecastingUtil {
    
    /**
     * Calculates forecast using Holt's Linear Trend Model (Double Exponential Smoothing)
     * 
     * @param array $data Historical sales data
     * @param float $alpha Smoothing constant for level (0-1)
     * @param float $beta Smoothing constant for trend (0-1)
     * @return array [forecast, trend_percentage, confidence]
     */
    public static function holtLinearForecast($data, $alpha = 0.5, $beta = 0.3) {
        $n = count($data);
        
        // Handle insufficient data
        if ($n < 1) return ['forecast' => 0, 'trend' => 0, 'confidence' => 0];
        if ($n < 2) return ['forecast' => $data[0], 'trend' => 0, 'confidence' => 20];
        
        // Initialization
        $level = $data[0];
        $trend = $data[1] - $data[0];
        
        // Iterative calculation
        for ($i = 1; $i < $n; $i++) {
            $prev_level = $level;
            $level = $alpha * $data[$i] + (1 - $alpha) * ($level + $trend);
            $trend = $beta * ($level - $prev_level) + (1 - $beta) * $trend;
        }
        
        // Forecast for next month (m=1)
        $forecast = max(0, round($level + $trend, 2));
        
        // Calculate Trend Percentage (relative to the last level)
        $trend_percentage = ($level > 0) ? round(($trend / $level) * 100, 1) : 0;
        
        // Basic Confidence Score (based on data size and consistency)
        $confidence = min(95, ($n * 10) + 20); 
        
        return [
            'forecast' => $forecast,
            'trend_percentage' => $trend_percentage,
            'confidence' => $confidence
        ];
    }
}
