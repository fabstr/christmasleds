#ifndef CHRISTMASLEDS_H
#define CHRISTMASLEDS_H


// LED:s
#define RED 6
#define GREEN 5
#define BLUE 9

// pi and 2*pi
#define PI  3.141592654
#define PI2 (PI*2)

// network stuff
#define PORT 8467
#define BUFFSIZE 17

struct fourierSeries {
	int a0;
	int N;
	float *an;
	float *bn;
};

struct colourSettingsFourier {
	// the time to sleep between updates
	int waittime;

	// the amount we increase x with each update
	float xstep;

	// the period of the sin/cos functions
	float period;

	// the current x value
	float x;

	// the red/green/blue colours
	struct fourierSeries red;
	struct fourierSeries green;
	struct fourierSeries blue;
};

#endif /* CHRISTMASLEDS_H */
