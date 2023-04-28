% Detailed Design Procedure for Wind sensor boost converter
Vin = 3.5; % (Volts) Minimal Voltage in
Vout = 12; % (Volts) Desired output voltage
Vf = 0.6; % (Volts) Forward Voltage drop of Diode
Iout = 0.050; % (Amps) Expected output current
fmin = 87000; % Minimum Desired output switching frequency
Vripple = 0.05; % Desired peak-to-peak output ripple voltage

ton_over_toff = (Vout+Vf)/(Vin)
ton_plus_toff = 1/fmin
toff = ton_plus_toff/(ton_over_toff+1)
ton = ton_plus_toff - toff
Ct = 4*10^-5*ton
Ipk_switch = 2*Iout*(ton_over_toff+1)
Rsc = 0.3/Ipk_switch
Lmin = (Vin/Ipk_switch)*ton
Co = 9*Iout*ton/Vripple
R2_over_R1 = (Vout/1.25)-1