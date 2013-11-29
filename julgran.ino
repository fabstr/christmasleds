#include <SPI.h>
#include <Ethernet.h>

// enable or disable serial debugging
#define SER 0

// LED:s
#define RED 9
#define GREEN 5
#define BLUE 6

// network stuff
#define PORT 8467
#define BUFFSIZE 17
byte mac[] = {0x00, 0xAA, 0xBB, 0xCC, 0xDE, 0x02};
byte ip[] = {192, 168, 1, 4};
byte gateway[] = {192, 168, 1, 253};
byte subnet[] = {255, 255, 255, 0};
EthernetServer server = EthernetServer(PORT);

/* 
 * An abstract description of
 * the colour function that is
 * used.
 * y(x):=A*sin(B/c*x+D)+E
 */
struct colourFunction {
  unsigned char a;
  unsigned char b;
  unsigned char c;
  float bc; // bc = B / C
  unsigned char d;
  unsigned char e;
};

/*
 * A program is defined by
 * three colour functions and
 * the time between each iteration.
 */
struct colourSettings {
  unsigned char waittime;
  struct colourFunction red;
  struct colourFunction green;
  struct colourFunction blue;
};


struct colourSettings cs;
int x = 0;
byte buff[BUFFSIZE];

void setup()
{
  Ethernet.begin(mac, ip, gateway, subnet);
#if SER
  Serial.begin(9600);
  Serial.println(Ethernet.localIP()); 
#endif
  selfTest();  
  selfTest();  
  server.begin();
  
  /* set a default program */
  cs.waittime = 10;
  cs.red.a = cs.green.a = cs.blue.a = 0;
  cs.red.b = cs.green.b = cs.blue.b = 22;
  cs.red.c = cs.green.c = cs.blue.c = 255;
  cs.red.d = cs.green.d = cs.blue.d = 0;
  cs.red.e = cs.green.e = cs.blue.e = 255;
  int i = 0;
  
  /* set buffer to 0 */
  for (i; i<BUFFSIZE; i++) buff[i] = 0;
}


void loop()
{
  EthernetClient client = server.available();
  if (client == true) { /* got connection, read and parse data */
    parsePacketIntoSettings(client);
#if SER
    printSettings();
#endif
  } else { /* there is no data available, update instead */
    unsigned char r = cs.red.a * sin(x*cs.red.bc + cs.red.d) + cs.red.e;
    unsigned char g = floor(cs.green.a * sin(x*cs.green.bc + cs.green.d)) + cs.green.e;
    unsigned char b = cs.blue.a * sin(x*cs.blue.bc + cs.blue.d) + cs.blue.e;
    analogWrite(RED, r);
    analogWrite(GREEN, g);
    analogWrite(BLUE, b);
#if SER
  //  Serial.println(cs.green.a*sin(x*cs.green.bc+cs.green.d)+cs.green.e);
#endif
    x++;
    delay(cs.waittime);
  }
}

void parsePacketIntoSettings(EthernetClient c) 
{
  float a,b;
  char v;
  
  /* read data */
  v = c.read(); /* read and discard this */
  cs.waittime = c.read();
  cs.red.a = c.read();
  cs.red.b = c.read();
  cs.red.c = c.read();
  cs.red.d = c.read();
  cs.red.e = c.read();
  cs.green.a = c.read();
  cs.green.b = c.read();
  cs.green.c = c.read();
  cs.green.d = c.read();
  cs.green.e = c.read();
  cs.blue.a = c.read();
  cs.blue.b = c.read();
  cs.blue.c = c.read();
  cs.blue.d = c.read();
  cs.blue.e = c.read();
  
  /* create bc =:= b/c */
  a = (float) cs.red.b;
  b = (float) cs.red.c;
  cs.red.bc = a/b;
  a = (float) cs.green.b;
  b = (float) cs.green.c;
  cs.green.bc = a/b;
  a = (float) cs.blue.b;
  b = (float) cs.blue.c;
  cs.blue.bc = a/b;
#if SER
  Serial.println(cs.red.bc);
  Serial.println(cs.green.bc);
  Serial.println(cs.blue.bc);
#endif
}
#if SER
void printSettings()
{
  Serial.println("****************************************");
  Serial.print("Waittime: ");
  Serial.print(cs.waittime, DEC);
  Serial.println(" ms");
  Serial.print("Red:      r(t)=");
  Serial.print(cs.red.a, DEC); Serial.print("*sin(");
  Serial.print(cs.red.b, DEC); Serial.print("*t/");
  Serial.print(cs.red.c, DEC); Serial.print("+");
  Serial.print(cs.red.d, DEC); Serial.print(")+");
  Serial.print(cs.red.e, DEC); Serial.print("\n");
  Serial.print("Green:    g(t)=");
  Serial.print(cs.green.a, DEC); Serial.print("*sin(");
  Serial.print(cs.green.b, DEC); Serial.print("/");
  Serial.print(cs.green.c, DEC); Serial.print("*t+");
  Serial.print(cs.green.d, DEC); Serial.print(")+");
  Serial.print(cs.green.e, DEC); Serial.print("\n");
  Serial.print("Blue:     b(t)=");
  Serial.print(cs.blue.a, DEC); Serial.print("*sin(");
  Serial.print(cs.blue.b, DEC); Serial.print("/");
  Serial.print(cs.blue.c, DEC); Serial.print("*t+");
  Serial.print(cs.blue.e, DEC); Serial.print(")+");
  Serial.print(cs.blue.e, DEC); Serial.print("\n");
  Serial.println("****************************************");
}
#endif
void selfTest()
{
  analogWrite(RED, 0);
  analogWrite(GREEN, 0);
  analogWrite(BLUE, 0);
  
  analogWrite(RED, 255);
  delay(1000);
  analogWrite(RED, 0);
  analogWrite(GREEN, 255);
  delay(1000);
  analogWrite(GREEN, 0);
  analogWrite(BLUE, 255);
  delay(1000);
  analogWrite(BLUE, 0);
}
