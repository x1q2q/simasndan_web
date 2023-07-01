function formatRupiah(bilangan) {
    var	reverse = bilangan.toString().split('').reverse().join(''),
      ribuan 	= reverse.match(/\d{1,3}/g);
      ribuan	= ribuan.join('.').split('').reverse().join('');
    return "Rp"+ ribuan;
}
const isNotEmptyValue = (str) => {
  return (str == "" || str == null) ? 0:1;
}
function showToast(tipe, title, msg, elem){ // customize dewe
  resetToast(elem,tipe);
  let toastEx = $(elem);
  $(elem).addClass('bg-'+tipe);
  $(elem).find('.toast-title').text(title);
  $(elem).find('.toast-body').text(msg);
  const toastPlacement = new bootstrap.Toast(toastEx);
  toastPlacement.show();
}
function resetToast(elem,tipe){ // to reset before the class
  let listTipeAlertAvail = ['success','danger','warning','secondary'];
  let filtTipeAlertAvail = listTipeAlertAvail.filter(el => el != tipe);
  filtTipeAlertAvail.forEach(element => {
    $(elem).removeClass('bg-'+element);
  });
}
function resetValidationError(element='#form-save'){
  $(element).each(function(){
      $(this).find('.invalid-feedback').remove();
      $(this).find('.form-control,.custom-file').removeClass('is-invalid');
  });
}