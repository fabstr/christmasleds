#ifndef DEBUG_H
#define DEBUG_H

// enable or disable serial debugging
#define SER 0

#if SER 
#define DEBUG(...) __VA_ARGS__
#else
#define DEBUG(...) {}
#endif

#if SER
void printFourierSettings(struct colourSettingsFourier *csf);
#endif /* SER */

#endif /* DEBUG_H */
