/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-load-cell-hx711/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/

// Calibrating the load cell
#include <Arduino.h>
#include "soc/rtc.h"
#include "HX711.h"
#include <Wire.h>
#include "SSD1306.h"

//screen setup
SSD1306 display(0x3c, 13, 15); 

// HX711 circuit wiring
const int LOADCELL_DOUT_PIN = 2;
const int LOADCELL_SCK_PIN = 14;

HX711 scale;

void setup() {
  display.init();
  display.flipScreenVertically();
  Serial.begin(115200);
  rtc_cpu_freq_config_t config;
  rtc_clk_cpu_freq_get_config(&config);
  rtc_clk_cpu_freq_to_config(RTC_CPU_FREQ_80M, &config);
  rtc_clk_cpu_freq_set_config_fast(&config);
  scale.begin(LOADCELL_DOUT_PIN, LOADCELL_SCK_PIN);
}

void loop() {

  if (scale.is_ready()) {
    scale.set_scale();
    display.clear();
    display.drawString(0, 0, "Tare... remove any weights from the scale."); 
    display.display();  
    delay(5000);
    scale.tare();
    display.clear();
    display.drawString(0, 0, "Place a known weight on the scale...");
    display.display();
    delay(5000);
    long reading = scale.get_units(10);
    display.clear();
    display.drawString(0, 0, "result: "+String(reading));
    display.display();
  } 
  else {
    display.clear();
    display.drawString(0, 0, "HX711 not found.");
    display.display();
  }
  delay(1000);
}

//calibration factor will be the (reading)/(known weight)
