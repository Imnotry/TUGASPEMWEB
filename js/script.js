// script.js - interaksi & animasi (requires jQuery)
$(function(){
  // tahun
  $('#year, #year2, #year3').text(new Date().getFullYear());

  // promo slider
  const slides = $('.promo-slider .slide');
  let sidx = 0;
  slides.hide().eq(0).show();
  setInterval(() => {
    slides.eq(sidx).fadeOut(400);
    sidx = (sidx + 1) % slides.length;
    slides.eq(sidx).fadeIn(400);
  }, 4000);

  // product hover glow (handled by CSS), add click behavior
  $('.add-cart').on('click', function(){
    const name = $(this).data('name') || 'Produk';
    sessionStorage.setItem('prefillProduct', name);
    // light flash effect
    $('body').append('<div class="tmpflash"></div>');
    setTimeout(()=>$('.tmpflash').fadeOut(400,function(){$(this).remove()}),600);
    window.location.href = 'contact.php';
  });

  // prefill contact form
  if ($('#contactForm').length) {
    const pre = sessionStorage.getItem('prefillProduct');
    if (pre) {
      $('textarea[name=message]').val(`Halo, saya ingin memesan/bertanya tentang: ${pre}`);
      sessionStorage.removeItem('prefillProduct');
    }

    // client validation
    $('#contactForm').on('submit', function(e){
      const name = $.trim($('[name=name]').val());
      const email = $.trim($('[name=email]').val());
      const msg = $.trim($('[name=message]').val());
      let errs = [];
      if (!name) errs.push('Nama wajib diisi.');
      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errs.push('Email tidak valid.');
      if (!msg) errs.push('Pesan tidak boleh kosong.');
      if (errs.length) {
        e.preventDefault();
        alert(errs.join('\n'));
      }
    });
  }
});
