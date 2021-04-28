%ter20120426104311s

vars = who;
if length(vars) == 4
    if   a >= 0 && a < 10 && b >= 0 && b < 10 && c >= 0 && c < 10 && d >= 0 && d < 10          
		    bdclose('all');
		    
		    % Datos especificos de TS
		    PracticeFile = 'ter20120426104311s';       %'termicoddmmaahhmmsss';
		    Graph1File   = 'temperaturas.jpg';
		    Plot1        = 'plot(temp(:,1),temp(:,2:3))';
		    Graph2File   = 'mandots.jpg';
		    Plot2        = 'plot(man(:,1),man(:,2))';
		    
		    
		    % Inicilizar la cadena de retorno.
		    retstr = char('');
		    
		    % Inicializacion de la estructura de datos
		    p = what;
		    mldir  = p.path;          % Path completo donde esta el mdl y el html plantilla
		    outdir = [p.path '\out']; % Path donde quedara el html resultante con sus graficas OjO: debe copiarse a él el esquema
		    		    
		    pf = PracticeFile;
		    
		    % Simulación en MATLAB
            
            try
                eval(pf);	
                sim(pf);
            catch
                varerror= 'Hubo error en la ejecución del modelo.';
				close_system(gcs,0);
				cd ..;
				clc
                return;
            end
		    
		    % Creando las figuras
		    cd(outdir);
		    
		    h = figure('visible','off');
		    
		    % Ajuste del tamaño de la figura
		    p = get(gcf, 'position');
		    p(3) = 380;
		    p(4) = 310;
		    set(gcf, 'Position', p, 'PaperPosition', [.25 .25 10 7.5]);
		    
		    % Creando figura 1
		    eval(Plot1);
		    grid on;
		    legend('Deseada','Simulada','Location','SouthEast');
		    GraphFile = sprintf(Graph1File);
		    wsprintjpeg(h,GraphFile);
		    
            %Creando figura 2
		    eval(Plot2);
		    grid on;
            GraphFile = sprintf(Graph2File);
		    wsprintjpeg(h,GraphFile);
		    
		    close(h);
            		    
		    salida = [temp];
            mando =  [man];
			str = ['save ' PracticeFile '.mat' ' salida mando -v4'];
			eval(str);
		    
		    % Coloque las variables que ud quiera devolver al documento HTML de salida
		    % dentro de una estructura de salida.  
		    cd(mldir);
		    
		    % Cierra el mdl
		    close_system(gcs,0);
		    varerror = '0';
			cd ..;
		    clc
    else
    		varerror= 'Hay variables fuera de rango.';
    end
else
    varerror= 'Las variables no se han introducido correctamente.';
end

% 1 = ERROR: Hay variables fuera de rango.
% 2 = ERROR: Las variables no se han introducido correctamente.Numero de parametros =4 <---Este es ! 
