function retstr = salida(simout)
% Practica de control en casscada

% Inicilizar la cadena de retorno.
retstr = char('');

% Carga variables por si se necesita alguna
% por ejemplo PracticeFile
load globales;
    
% Salto a la carpeta de salida
cd('out');
		    
% Genera puntero a figura
h = figure('visible','off');
p = get(gcf, 'position');
p(3) = 380;
p(4) = 310;
set(gcf, 'Position', p, 'PaperPosition', [.25 .25 4 3]);
    
% Creando figura 1
Ti = 4.5;
Tf = 6.5;
GraphName   = 'CS_PV_poszoom.jpg';
stairs(simout.time(round(Ti/Tm):round(Tf/Tm)), simout.signals.values(round(Ti/Tm):round(Tf/Tm),4:6)); 
legend('Posición deseada (gr)','Posición medida (gr)','Posición filtrada (gr)','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);

% Creando figura 2
GraphName   = 'CS_PV_posicion.jpg';
stairs(simout.time, simout.signals.values(:,4:6));
legend('Posición deseada (gr)','Posición medida (gr)','Posición filtrada (gr)','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);

% Creando figura 3
GraphName   = 'CS_PV_velocidad.jpg';
stairs(simout.time, simout.signals.values(:,1:3));
legend('Velocidad deseada (rpm)','Velocidad medida (rpm)','Velocidad filtrada (rpm)','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);

% Creando figura 3
GraphName   = 'CS_PV_mando.jpg';
stairs(simout.time, simout.signals.values(:,7));
legend('Mando aplicado (V)','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);

close(h);
            		    
% Creando el fichero de respuesta.
vec = [simout.time simout.signals.values];
str = ['save ' PracticeFile ' vec -ascii -tabs'];
eval(str);
		    
% Retorno a la carpeta de trabajo
cd('..');
		    
varerror = '0';
