# Filemanager
Gerenciador de arquivos compatível com ISPConfig usando Apache, linguagens usadas PHP, bootstrap, Javascript e utilizando CodeMirror

<h2>Ferramentas que podem ser úteis</h2>
<a href="https://winscp.net/eng/downloads.php">WinSCP <img src="https://www.ultratechinformatica.com.br/assets/images/github/winscp.jpg" height="32px" width="32px" /></a>

<h2>Primeiro passo</h2>
É Necessário baixar os arquivos e mover para o diretório /usr/share/filemanager <br>
<img src="https://www.ultratechinformatica.com.br/assets/images/github/caminho_filemanager.png" />

<h2>Segundo Passo</h2>
É necessário que seja criado um arquivo chamado filemanager.conf na pasta /etc/httpd/conf.d/ Dentro dele colocar o código para criar um Alias e liberar o diretório para acesso <br>
<img src="https://www.ultratechinformatica.com.br/assets/images/github/img2.png" />

Também é necessário adicionar as seguintes linhas no arquivo ispconfig.conf dentro de /etc/httpd/conf/sites-available
<img src="https://www.ultratechinformatica.com.br/assets/images/github/img3.png" />

Feito isso podemos reiniciar o serviço httpd, para isso execute o comando "sudo systemctl restart httpd.service" sem aspas
