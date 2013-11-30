#include <SPI.h>
#include <Ethernet.h>

// enable or disable serial debugging
#define SER 0

// LED:s
#define RED 9
#define GREEN 5
#define BLUE 6

// pi and 2*pi
#define PI  3.141592654
#define PI2 (PI*2)

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

	/* set buffer to 0 */
	memset(buff, 0, BUFFSIZE);
}


unsigned char fun(unsigned char a, unsigned char bc, unsigned char d, 
		unsigned char e) 
{
	return a*sin(bc+d)+e;
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
		unsigned char r = fun(cs.red.a, cs.red.bc, cs.red.d, cs.red.e);
		unsigned char g = fun(cs.green.a, cs.green.bc, cs.green.d, cs.green.e);
		unsigned char b = fun(cs.blue.a, cs.blue.bc, cs.blue.d, cs.blue.e);
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

void parsePacketIntoSettings(EthernetClient client) 
{
	float b,c;

	/* read and discard the first byte */
	(void) client.read(); 

	/* read data */
	cs.waittime = client.read();
	cs.red.a = client.read();
	cs.red.b = client.read();
	cs.red.c = client.read();
	cs.red.d = client.read();
	cs.red.e = client.read();
	cs.green.a = client.read();
	cs.green.b = client.read();
	cs.green.c = client.read();
	cs.green.d = client.read();
	cs.green.e = client.read();
	cs.blue.a = client.read();
	cs.blue.b = client.read();
	cs.blue.c = client.read();
	cs.blue.d = client.read();
	cs.blue.e = client.read();

	/* create bc = b/c */
	b = (float) cs.red.b;
	c = (float) cs.red.c;
	cs.red.bc = b/c;
	b = (float) cs.green.b;
	c = (float) cs.green.c;
	cs.green.bc = b/c;
	b = (float) cs.blue.b;
	c = (float) cs.blue.c;
	cs.blue.bc = b/c;
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
	Serial.print("Red:   r(t)=");
	Serial.print(cs.red.a, DEC); Serial.print("*sin(");
	Serial.print(cs.red.b, DEC); Serial.print("*t/");
	Serial.print(cs.red.c, DEC); Serial.print("+");
	Serial.print(cs.red.d, DEC); Serial.print(")+");
	Serial.print(cs.red.e, DEC); Serial.print("\n");
	Serial.print("Green: g(t)=");
	Serial.print(cs.green.a, DEC); Serial.print("*sin(");
	Serial.print(cs.green.b, DEC); Serial.print("/");
	Serial.print(cs.green.c, DEC); Serial.print("*t+");
	Serial.print(cs.green.d, DEC); Serial.print(")+");
	Serial.print(cs.green.e, DEC); Serial.print("\n");
	Serial.print("Blue:  b(t)=");
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
	/* make sure the leds are off */
	analogWrite(RED,   0);
	analogWrite(GREEN, 0);
	analogWrite(BLUE,   0);

	/* turn on each led for a second */
	analogWrite(RED,   255); delay(1000); analogWrite(RED,   0);
	analogWrite(GREEN, 255); delay(1000); analogWrite(GREEN, 0);
	analogWrite(BLUE,  255); delay(1000); analogWrite(BLUE,  0);

	/* make sure the leds are off */
	analogWrite(RED,   0);
	analogWrite(GREEN, 0);
	analogWrite(BLUE,  0);
}

/*
 * Compute the fourier series in the point x.
 * an[] An array of size N with the an coefficients 
 * bn[] An array of size N with the bn coefficients 
 * See http://en.wikipedia.org/wiki/Fourier_series.
 */
int fourier(int x, float an[], float bn[], float a0, int N, float P)
{
	float val = a0;
	float pre = PI2*x/P;

#ifdef SER
	unsigned long time = micros();
#endif
	
	for (int i=1; i<N; i++) {
		val += an[i-1]*cos(pre*i) + bn[i-1]*sin(pre*i);
	}

#ifdef SER
	unsigned long diff = micros() - time;
	Serial.print("Fourier took ");
	Serial.print(diff, DEC);
	Serial.println(" micro seconds");
#endif

	return (int) val;
}
