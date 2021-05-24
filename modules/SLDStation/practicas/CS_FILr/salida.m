function retstr = salida(simout)
% Practica de Identificación de motor al paso

load globales
		    		    
% Inicilizar la cadena de retorno.
retstr = char('');
		    
% Creando las figuras
cd(outdir);
		    
h = figure('visible','off');
		    
% Ajuste del tamaño de la figura
p = get(gcf, 'position');
p(3) = 380;
p(4) = 310;
set(gcf, 'Position', p, 'PaperPosition', [.25 .25 4 3]);
		    
% Creando figura 1
eval(Plot1);
grid on;
legend('Velocidad medida (rpm)','Velocidad filtrada (rpm)','Location','SouthEast');
GraphFile = sprintf(Graph1File);
print(h, '-djpeg', '-r0', GraphFile);

% Creando figura 2
eval(Plot2);
grid on;
legend('Posición medida (gr)','Posición filtrada (gr)','Location','SouthEast');
GraphFile = sprintf(Graph2File);
print(h, '-djpeg', '-r0', GraphFile);
		    
close(h);
            		    
% Creando el fichero de respuesta.
vec = [simout.time simout.signals.values];
str = ['save ' PracticeFile ' vec -ascii -tabs'];
eval(str);
		    
% Coloque las variables que ud quiera devolver al documento HTML de salida
% dentro de una estructura de salida.  
cd(mldir);
		    
varerror = '0';
disp('fin')
