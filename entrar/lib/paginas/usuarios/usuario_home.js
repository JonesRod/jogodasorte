function toggleMenu() {
    $('#menu').toggleClass('aberto');
}
/*function abrirNaDiv(link) {
    var div = document.getElementById('iconteudo');
    div.innerHTML = '<object type="text/html" data="' + link + '" style="width:100%; height:100%;">';
}*/
document.getElementById('logoutIcon').addEventListener('click', function() {
    // Coloque aqui o código para realizar o logout
    // Por exemplo, redirecionar para a página de logout ou fazer uma requisição AJAX para efetuar o logout
    // Exemplo de redirecionamento:
    window.location.href = 'usuario_logout.php';
});
function atualizarPagina() {
    location.reload(); // Recarrega a página
}