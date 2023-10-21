function toggleMenu() {
    $('#menu').toggleClass('aberto');
}
function abrirNaDiv(link) {
    var div = document.getElementById('conteudo');
    div.innerHTML = '<object type="text/html" data="' + link + '" style="width:100%; height:100%;">';
}
document.getElementById('logoutIcon').addEventListener('click', function() {
    window.location.href = 'usuario_logout.php';
});
function atualizarPagina() {
    location.reload(); // Recarrega a página
}