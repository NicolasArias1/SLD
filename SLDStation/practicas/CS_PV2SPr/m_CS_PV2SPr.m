% Practica de control en cascada

clc

% Parámetros que manda el SLD (luego hay que comentarlos)
% clear all
% 
% Tm = 0.01;   % Período de muestreo (0.001<=Tm<=1)
% SWsp = 1;    % 0 SP=step, 1 SP=jtraj
% Kv = 0.3151; % ganancia para prealimentación de velocidad
% Ka = 0.0496; % ganancia para prealimentación de aceleración
% 
% Pp = 0.5290; % P = kp     P+I/s = (tis+1)kp/Tis
% Ip = 0;      % I = kp/Ti
% Dp = 0;
% Kbp = 0;     % Ganancia del Antiwindup
% Fcdp = 5;    % Fc del filtro derivativo en Hz (N = 2*pi*Fcd;)
% SWp = 1;     % 0 realimenta medición sin filtro, 1 con filtro
% Np = 2;      % Orden del Filtro de posición
% Fcp = 5;     % Frecuencia de corte (Fc<Fm/2)
% 
% Pv = 0.3173; % P = kp     P+I/s = (tis+1)kp/Tis
% Iv = 0.6346; % I = kp/Ti
% Dv = 0;
% Kbv = 1;     % Ganancia del Antiwindup
% Fcdv = 5;    % Fc del filtro derivativo en Hz (N = 2*pi*Fcd;)
% SWv = 1;     % 0 realimenta medición sin filtro, 1 con filtro
% Nv = 2;      % Orden del Filtro de velocidad
% Fcv = 5;     % Frecuencia de corte (Fc<Fm/2)

% Chequeo de variables en rango (OjO: no poner 0 (cero), poner O (letra o) ) 
vars = who;
if length(vars) ~= 20
    varerror = 'ERROR: Las variables no se han introducido correctamente.';
elseif Tm < 0.001 || Tm > 1
    varerror = 'ERROR: Variables fuera de rango: O.OO1 <= Tm <= 1';
elseif ~(SWsp == 0 || SWsp == 1)
    varerror = 'ERROR: Variables fuera de rango: SW = O o 1';
elseif Fcdp < 0 || Fcdp > 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcd < Fm/2';
elseif Np < 1 || Np > 10
    varerror = 'ERROR: Variables fuera de rango: 1 <= Nv <= 1O (entero)';
elseif Fcp <= 0 || Fcp >= 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcp < Fm/2';
elseif ~(SWp == 0 || SWp == 1)
    varerror = 'ERROR: Variables fuera de rango: SW = O o 1';
elseif Fcdv < 0 || Fcdv > 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcd < Fm/2';
elseif Nv < 1 || Nv > 10
    varerror = 'ERROR: Variables fuera de rango: 1 <= Nv <= 1O (entero)';
elseif Fcv <= 0 || Fcv >= 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcv < Fm/2';
elseif ~(SWv == 0 || SWv == 1)
    varerror = 'ERROR: Variables fuera de rango: SW = O o 1';
else
    bdclose('all');
	% Presumo que no habrá error
	varerror = '0';
	
    Te = 10;    % Tiempo de experimento (1<=Tm<=10)
    Tp = 5;     % Instante del paso (Tp<Te)
    P0 = 0;
    Pi = -50;   % Posición inicial
    Pf = 50;    % Posición final
    
    % ----------- jtraj ----------- 
    
    tj = 3;
    t1 = 0;
    t2 = 5;
    
    T = 0:Tm:tj;
    [qd1,qd1p,qd1pp] = jtraj(P0,Pi,T);
    [qd2,qd2p,qd2pp] = jtraj(Pi,Pf,T);

    qds0 = ones(t1/Tm,1)*P0;
    qds1 = ones((t2-t1-tj)/Tm,1)*Pi;
    qds2 = ones((Te-t2-tj)/Tm,1)*Pf;

    qd = [qds0;qd1;qds1;qd2;qds2];
    qdp = [qds0*0;qd1p;qds1*0;qd2p;qds2*0];
    qdpp = [qds0*0;qd1pp;qds1*0;qd2pp;qds2*0];
    tt = (0:Tm:Te)';
    qd = qd(1:length(tt));
    qdp = qdp(1:length(tt));
    qdpp = qdpp(1:length(tt));

    spq.time = tt;
    spq.signals.values = [qd qdp qdpp];
    
    % ----------- jtraj ----------- 
    
    
	% Iedentificador de la práctica
	PracticeFile = 'CS_PV2SPr';
			    
	% Carga y setea el mdl
	eval(PracticeFile);
    set_param([PracticeFile '/SPSelector'],'CurrentSetting',num2str(~SWsp));
	set_param([PracticeFile '/VSelector'],'CurrentSetting',num2str(~SWv));
    set_param([PracticeFile '/PSelector'],'CurrentSetting',num2str(~SWp));
	
    % Salva variables para que luego las vea 'salida'
    save globales;
    
    % Compila para RT
%     try
%         make_rtw;
%     catch
%         varerror = 'Error creando el código en Real Time Windows Target.';
%         return;
%     end
    
    try
        sim(gcs);
        salida(simout);
%         % Simulink cambia a modo externo
%         set_param(gcs,'SimulationMode','external');
%         % MatLab carga la aplicacion en tiempo real y la conecta con los bloques de simulink
%         set_param(gcs,'SimulationCommand','connect');
%         % Inicializa la simulacion en tiempo  real
%         set_param(gcs,'SimulationCommand','start');
    catch
        varerror = 'Error ejecutando el modelo.';
        return;
    end
	
end

varerror