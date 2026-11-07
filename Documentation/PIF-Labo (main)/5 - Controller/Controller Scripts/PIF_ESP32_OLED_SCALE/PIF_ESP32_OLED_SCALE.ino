//********************Libraries********************************
#include "SSD1306Wire.h"
#include "HX711.h"
#include <ESP32QRCodeReader.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <Bounce2.h>

//Debounce switch
#define BUTTON_PIN 12 
Bounce2::Button button = Bounce2::Button();
//Scheduler
#include <TaskScheduler.h>

//**************** Defining variables and constants ************
#define _TASK_SELF_DESTRUCT

// I/O
#define OUT1 16
#define IN1 12
#define FLASHLIGHT 4

// OLED Display
#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64
#define I2C_SDA 13
#define I2C_SCL 15
#define OLED_ADDR 0x3C
SSD1306Wire display(OLED_ADDR, I2C_SDA, I2C_SCL);

// QR
ESP32QRCodeReader reader(CAMERA_MODEL_AI_THINKER);
struct QRCodeData qrCodeData;
String Payload = "NULL";

//Weighting
#define HX711_SCK 14
#define HX711_DOUT 2
HX711 SCALE;
int new_weight = 0;
int old_weight = -1;
int MEASURE = 0;
//linear equation f(x)=ax+b (set first values to one (a=1, b=0))
int scale_scale = -755;  //=a (515)
int scale_offset = 0;   // =-b (2)

//ID of balance
String idBalance = "11";
String state = "Scanning";

//Scheduler
Scheduler ts;
void switchStatus();
void onQrCodeTask();

// Tasks
// Task taskSwitch runs every 50 milliseconds forever and adding task to the chain on creation
Task taskSwitch(50, TASK_FOREVER, &switchStatus, &ts, true); 
Task taskQR(100, TASK_FOREVER, &onQrCodeTask, &ts, true);

//************************************************** Basic functionsr********************************************
//Function to show 3 lines (given as parameters) on the OLED display
void showOLEDMessage(String line1, String line2, String line3) {
  display.init();  // clears screen
  display.flipScreenVertically();
  display.setFont(ArialMT_Plain_16);
  display.drawString(0, 0, line1);  //  adds to buffer
  display.drawString(0, 20, line2);
  display.drawString(0, 40, line3);
  display.display();  // displays content in buffer
}

//Function initialising and calibrating the scale
void SCALE_INIT() {
  SCALE.begin(HX711_DOUT, HX711_SCK);
  SCALE.power_down();
  SCALE.power_up();
  while (SCALE.is_ready() != 1) {
    //HX711 not found
  }
  //HX711 ready!
  SCALE.set_scale(scale_scale);
  SCALE.set_offset(scale_offset);
  SCALE.tare();
}
//Function to get the measurement of the weight
int SCALE_GET() {
  new_weight = SCALE.get_units(10);
  if (new_weight != old_weight) {
    return (new_weight);
  }
}


//************************************************** Checking status of switch********************************************
//Function to check the status of the switch and trigger the according action
void switchStatus() {
  button.update();
  if (button.pressed()){
    //based on the current state start QR-code or measuring of weight
    if (state == "Scanning" && Payload == "NULL" && !taskQR.isEnabled()) {
      showOLEDMessage("Reading", "QR", "Code");
      reader.beginOnCore(1);
      taskQR.enable();
      taskSwitch.abort();
    } else if (state == "Measuring" && !taskQR.isEnabled()) {
      startWeighting();
    }
  }
}
//************************************************** Start weighting process*******************************************
void startWeighting() {
  MEASURE = SCALE_GET(); //get the measurement
  if (MEASURE != 0) {
    showOLEDMessage("2. Weight:", String(MEASURE), "g");
    delay(1000);
    // Transfer data
    showOLEDMessage("3. Transfer", "QR " + Payload, String(MEASURE) + " g");
    delay(2000);
    showOLEDMessage("4. Remove", "your", "trash!");
    Payload = "NULL";
    state = "Scanning";
    delay(2000);
    showOLEDMessage("1. Press switch", "to start reading", "QR-code");
  } else {
    showOLEDMessage("No trash measured", "1.Put your Trash", "2.Press switch");
  }
}
//************************************************** QR Code Scanner********************************************
void onQrCodeTask() {
  taskSwitch.disable(); 
  struct QRCodeData qrCodeData;
  if (reader.receiveQrCode(&qrCodeData, 100) && qrCodeData.valid) {
      Payload = ((const char *)qrCodeData.payload); 
      if (Payload != "NULL") {
        reader.end();
        taskQR.disable();
          SCALE_INIT();
          state = "Measuring";
          delay(2000);
          showOLEDMessage(Payload, "1.Put your Trash", "2.Press switch");
        }
  }
  taskSwitch.enable();
}



void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
  pinMode(FLASHLIGHT, OUTPUT);
  //Debounce the switch
  button.attach(BUTTON_PIN, INPUT); 
  // Debounce interval in milliseconds
  button.interval(5); 
  // Indicate that the low state corresponds to physically pressing the switch 
  button.setPressedState(LOW); 
  //Flashing light when starting up
  digitalWrite(FLASHLIGHT, HIGH);
  delay(100);
  digitalWrite(FLASHLIGHT, LOW);
  taskQR.disable();
  showOLEDMessage("", "Startup", "");
  delay(1000);
  reader.setup();
  showOLEDMessage("Press switch", "to start reading", "QR-code");
}

void loop() {
  // put your main code here, to run repeatedly:
  ts.execute();
}