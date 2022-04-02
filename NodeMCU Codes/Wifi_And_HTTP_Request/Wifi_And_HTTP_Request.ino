#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiClient.h>

const char* ssid = "YOUR_WIFI_NAME_HERE";
const char* password = "YOUR_WIFI_PASSWORD_HERE";

// Open https://webhook.site/ and get your URL and change it in below line
// Don't copy from the address bar! Use Copy to Clipboard in Your unique URL section
// Remove change https:/ to http:/
String server = "http://webhook.site/f52fe1c1-66c5-423c-af14-9b4a65472421";

void setup() {
  Serial.begin(115200); 
  delay(3000);
  WiFi.begin(ssid, password);
  Serial.print("Wifi: ");
  Serial.println(ssid);
  Serial.print("Connecting.");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("Connected !!!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;
    String getAPI = server + "?one=1&two=2&three=3&name=Test";
    http.begin(client, getAPI.c_str());
    int httpResponseCode = http.GET();
    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      String payload = http.getString();
      Serial.print("Response: ");
      Serial.println(payload);
    } else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    http.end();
  } else {
    Serial.println("WiFi Disconnected !!");
    delay(10000);
  }
}
