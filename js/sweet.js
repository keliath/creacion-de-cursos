function alerta(title, msg, btn) {
    Swal.fire({
        title: title,
        text: msg,
        icon: btn,
        showCancelButton: false,
        confirmButtonText: 'Aceptar'
    });
}

function swalerta(title, msg, msg2, btn, btntext) {
    Swal.fire({
        title: title,
        type: btn,
        html: msg + '<b>' + msg2 + '</b>',
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonText: btntext,
    });
}