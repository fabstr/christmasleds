#include <SPI.h>
#include <Ethernet.h>

#include "christmasleds.h"
#include "debug.h"

byte mac[] = {0x00, 0xAA, 0xBB, 0xCC, 0xDE, 0x02};
byte ip[] = {192, 168, 1, 4};
byte gateway[] = {192, 168, 1, 253};
byte subnet[] = {255, 255, 255, 0};

EthernetServer server = EthernetServer(PORT);

struct colourSettingsFourier csf;

void setup()
{
	Ethernet.begin(mac, ip, gateway, subnet);
	DEBUG(
		Serial.begin(9600);
		Serial.println(Ethernet.localIP()); 
	);
	selfTest();  
	selfTest();  
	server.begin();

	/* set a default program */
	csf.red.a0 = 128;
	csf.red.N = 1;
	csf.red.an = (float *) calloc(1, sizeof(float));
	csf.red.an[0] = 0;
	csf.red.bn = (float *) calloc(1, sizeof(float));
	csf.red.bn[0] = 1;

	csf.green.a0 = 128;
	csf.green.N = 1;
	csf.green.an = (float *) calloc(1, sizeof(float));
	csf.green.an[0] = 0;
	csf.green.bn = (float *) calloc(1, sizeof(float));
	csf.green.bn[0] = 1;

	csf.blue.a0 = 128;
	csf.blue.N = 1;
	csf.blue.an = (float *) calloc(1, sizeof(float));
	csf.blue.an[0] = 0;
	csf.blue.bn = (float *) calloc(1, sizeof(float));
	csf.blue.bn[0] = 1;
	
	csf.waittime = 500;
	csf.period = 6.28;
	csf.xstep = 0.01;
	csf.x = 0;

	DEBUG(
		printFourierSettings(&csf);
		Serial.println("Ready");
	);
}


void loop()
{
	EthernetClient client = server.available();
	if (client == true) { /* got connection, read and parse data */
		/* the first byte is the protocol version identifier */
		unsigned char version = client.parseInt();
		parseFourier(client);
		DEBUG(Serial.println(version);printFourierSettings(&csf););
	} else { /* there is no data available, update instead */
		updateFourier();
		csf.x += csf.xstep;

		if (csf.x > csf.period) {
			csf.x = 0;
		}
	}
}

void updateFourier()
{
	DEBUG(Serial.print("updating fourier "); Serial.println(csf.x););
	unsigned char r = fourier(&csf.red);
	unsigned char g = fourier(&csf.green);
	unsigned char b = fourier(&csf.blue);
	analogWrite(RED, r);
	analogWrite(GREEN, g);
	analogWrite(BLUE, b);
	DEBUG(
		Serial.print("r: "); Serial.println(r);
		Serial.print("g: "); Serial.println(g);
		Serial.print("b: "); Serial.println(b);
        );
	delay(csf.waittime);
}

void parseFourier(EthernetClient client)
{
	DEBUG(
		Serial.println("Parsing fourier");
		long time = millis();
	);

	/* read waittime, step and period */
	csf.waittime = client.parseInt();
	csf.xstep = client.parseFloat();
	csf.period = client.parseFloat();
	
	/* read red */
	csf.red.a0 = client.parseFloat();
	csf.red.N = client.parseInt();
	free(csf.red.an);
	free(csf.red.bn);
	csf.red.an = (float *) calloc(csf.red.N, sizeof(float));
	csf.red.bn = (float *) calloc(csf.red.N, sizeof(float));
	for(int i=0;i<csf.red.N;i++){csf.red.an[i]=client.parseFloat();}
	for(int i=0;i<csf.red.N;i++){csf.red.bn[i]=client.parseFloat();}
	
	/* read green */
	csf.green.a0 = client.parseFloat();
	csf.green.N = client.parseInt();
	free(csf.green.an);
	free(csf.green.bn);
	csf.green.an = (float *) calloc(csf.green.N, sizeof(float));
	csf.green.bn = (float *) calloc(csf.green.N, sizeof(float));
	for(int i=0;i<csf.green.N;i++){csf.green.an[i]=client.parseFloat();}
	for(int i=0;i<csf.green.N;i++){csf.green.bn[i]=client.parseFloat();}
	
	/* read blue */
	csf.blue.a0 = client.parseFloat();
	csf.blue.N = client.parseInt();
	free(csf.blue.an);
	free(csf.blue.bn);
	csf.blue.an = (float *) calloc(csf.blue.N, sizeof(float));
	csf.blue.bn = (float *) calloc(csf.blue.N, sizeof(float));
	for(int i=0;i<csf.blue.N;i++){csf.blue.an[i]=client.parseFloat();}
	for(int i=0;i<csf.blue.N;i++){csf.blue.bn[i]=client.parseFloat();}

	/* we have read what we wanted, discard the rest data (if any) */
	client.flush();

	DEBUG(
		long diff = millis() - time;
		Serial.println("Fourier parsed: ");
		Serial.print(diff);
		Serial.println(" ms");
	);
}

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
 * See http://en.wikipedia.org/wiki/Fourier_series.
 */
int fourier(struct fourierSeries *col)
{
	float val = 0;
	float pre = PI2*csf.x/csf.period;

	DEBUG(unsigned long time = micros(););
	
	for (int i=1; i<=col->N; i++) {
		val += col->an[i-1]*cos(pre*i) + col->bn[i-1]*sin(pre*i);
	}

	val = val*128+col->a0;

	DEBUG(
		unsigned long diff = micros() - time;
		Serial.print("Fourier took ");
		Serial.print(diff, DEC);
		Serial.println(" microseconds");
	);

	return (int) val;
}
