#include <Wire.h> 
#include <LiquidCrystal_I2C.h>

LiquidCrystal_I2C lcd(0x27, 16, 2);
char letters[] = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

void setup() {
  lcd.begin();
  lcd.backlight();
  lcd.clear();
}
 
void loop() {
  for (int letter = 0; letter < (sizeof letters) -1; letter++) {
    for (int row = 0; row < 2; row++) {
      for (int column = 0; column < 16; column++) {
        lcd.setCursor(column, row);
        lcd.print(letters[letter]);
      }
    }
    delay(500);
    lcd.clear();
  }
}
