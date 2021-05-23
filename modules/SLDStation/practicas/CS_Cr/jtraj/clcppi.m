clear all

% % en la web:
% Tm   = 0.01
% SWsp = 1
% Kv   = 0.3151
% Ka   = 0.0496
% Pp   = 0.592
% Ip   = 0
% Dp   = 0
% Kbp  = 0
% Fcdp = 5
% SWp  = 1
% Np   = 2
% Fcp  = 5
% Pv   = 0.3173
% Iv   = 0.6346
% Dv   = 0
% Kbv  = 1
% Fcdv = 5
% SWv  = 1
% Nv   = 2
% Fcv  = 5



Tm = 0.01;

tj = 3;
tt = 10;
t1 = 0;
t2 = 5;
q0 = 0;
q1 = -50;
q2 = 50;

T = 0:Tm:tj;
[qd1,qd1p,qd1pp] = jtraj(q0,q1,T);
[qd2,qd2p,qd2pp] = jtraj(q1,q2,T);

qds0 = ones(t1/Tm,1)*q0;
qds1 = ones((t2-t1-tj)/Tm,1)*q1;
qds2 = ones((tt-t2-tj)/Tm,1)*q2;

qd = [qds0;qd1;qds1;qd2;qds2];
qdp = [qds0*0;qd1p;qds1*0;qd2p;qds2*0];
qdpp = [qds0*0;qd1pp;qds1*0;qd2pp;qds2*0];
tt = (0:Tm:tt)';
qd = qd(1:length(tt));
qdp = qdp(1:length(tt));
qdpp = qdpp(1:length(tt));

subplot(3,1,1), plot(tt,qd)
subplot(3,1,2), plot(tt,qdp)
subplot(3,1,3), plot(tt,qdpp)

spq.time = tt;
spq.signals.values = [qd qdp qdpp];


% --------- Ajuste PPI: ---------

%tss = 1.5; 
fi = 0.707;

k = 360/60;
km = 10;
tm = 0.5;

tv = tm;
%wn = 4/(fi*tss);
wn = 2*pi*5/7; % wn/2pi < Fc/10 (Fc: Fc de los filtros de la medición)
%wn = 2*pi*5;
kp = wn/(2*fi*k);
kv = 2*fi*wn*tv/km;

KA = tv/(kp*kv*km*k);
KV = 1/(kp*k);

save globales