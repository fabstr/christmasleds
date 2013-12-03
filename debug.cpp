#include <SPI.h>
#include <Ethernet.h>
#include "christmasleds.h"
#include "debug.h"

#if SER
void printFourierSettings(struct colourSettingsFourier *csf) 
{
	Serial.println("****************************************");
	Serial.print("Waittime, step, period ");
	Serial.println(csf->waittime);
	Serial.println(csf->xstep);
	Serial.println(csf->period);

	Serial.println("red{a0 N P an{} bn{}}");
	Serial.println(csf->red.a0);
	Serial.println(csf->red.N);
	Serial.print("{");
	for(int i=0;i<csf->red.N;i++){Serial.print(csf->red.an[i]);Serial.print(" ");}
	Serial.println("}"); Serial.print("{");
	for(int i=0;i<csf->red.N;i++){Serial.print(csf->red.bn[i]);Serial.print(" ");}
	Serial.println("}");
	Serial.println("green{a0 N P an{} bn{}}");
	Serial.println(csf->green.a0);
	Serial.println(csf->green.N);
	Serial.print("{");
	for(int i=0;i<csf->green.N;i++){Serial.print(csf->green.an[i]);Serial.print(" ");}
	Serial.println("}"); Serial.print("{");
	for(int i=0;i<csf->green.N;i++){Serial.print(csf->green.bn[i]);Serial.print(" ");}
	Serial.println("}");
	Serial.println("blue{a0 N P an{} bn{}}");
	Serial.println(csf->blue.a0);
	Serial.println(csf->blue.N);
	Serial.print("{");
	for(int i=0;i<csf->blue.N;i++){Serial.print(csf->blue.an[i]);Serial.print(" ");}
	Serial.println("}"); Serial.print("{");
	for(int i=0;i<csf->blue.N;i++){Serial.print(csf->blue.bn[i]);Serial.print(" ");}
	Serial.println("}");
	Serial.println("****************************************");
}
#endif /* SER */
