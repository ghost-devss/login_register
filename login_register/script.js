function showForm(id) {
    document.querySelectorAll('.form').forEach(function(f) {
        f.classList.remove('show');
    });
    document.querySelectorAll('.tab').forEach(function(t) {
        t.classList.remove('active');
    });

    document.getElementById(id).classList.add('show');

    var tabs = document.querySelectorAll('.tab');
    if (id === 'login') {
        tabs[0].classList.add('active');
        document.getElementById('form-title').textContent = 'Bem-vindo de volta';
        document.getElementById('form-sub').textContent   = 'Entre na sua conta para continuar';
    } else {
        tabs[1].classList.add('active');
        document.getElementById('form-title').textContent = 'Criar conta';
        document.getElementById('form-sub').textContent   = 'Preencha os dados para se registrar';
    }
}