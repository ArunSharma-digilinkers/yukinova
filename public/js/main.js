  document.querySelectorAll('.ckeditor').forEach((editor) => {
        ClassicEditor
            .create(editor, {
                toolbar: [
                    'heading',
                    '|',
                    'bold', 'italic', 'underline', 'strikethrough',
                    '|',
                    'bulletedList', 'numberedList',
                    '|',
                    'link', 'blockQuote',
                    '|',
                    'undo', 'redo'
                ]
            })
            .catch(error => {
                console.error(error);
            });
    });

let removedImages = [];

function removeImage(imageName, index) {

    if (confirm('Are you sure you want to remove this image?')) {

        removedImages.push(imageName);

        document.getElementById('removed_images').value = removedImages.join(',');

        let imageBox = document.getElementById('image-box-' + index);

        if (imageBox) {
            imageBox.remove();
        }

        console.log("Removed:", removedImages);
    }
}


$(document).ready(function () {
    $('.testimonial-carousel').owlCarousel({
        loop: true,
        margin: 25,
        autoplay: true,
        autoplayTimeout: 4000,
        smartSpeed: 800,
        dots: true,
        nav: false,
        responsive: {
            0: { items: 1 },
            768: { items: 2 },
            1200: { items: 3 }
        }
    });
});

$(document).ready(function () {

    var owl = $('.gallery-carousel');

    owl.owlCarousel({
        loop: false,
        margin: 25,
        autoplay: false,
        smartSpeed: 800,
        dots: true,
        nav: true,
navText: [
    '<i class="fa fa-angle-left"></i>',
    '<i class="fa fa-angle-right"></i>'
],
        responsive: {
            0: { items: 4 },
            768: { items: 4 },
            1200: { items: 4 }
        },
        onInitialized: toggleNav,
        onResized: toggleNav
    });

    function toggleNav(event) {
        var carousel = event.relatedTarget;
        var currentItems = carousel.settings.items;
        var totalItems = carousel.items().length;

        if (totalItems <= currentItems) {
            $(event.target).find('.owl-nav').hide();
        } else {
            $(event.target).find('.owl-nav').show();
        }
    }

});

$(document).ready(function () {
    // Only enable hover for large screens
    function enableHoverDropdown() {
        if (window.innerWidth >= 992) {
            $('.dropdown').hover(
                function () {
                    $(this).addClass('show');
                    $(this).find('.dropdown-toggle').attr('aria-expanded', 'true');
                    $(this).find('.dropdown-menu').addClass('show');
                },
                function () {
                    $(this).removeClass('show');
                    $(this).find('.dropdown-toggle').attr('aria-expanded', 'false');
                    $(this).find('.dropdown-menu').removeClass('show');
                }
            );
        } else {
            // Remove hover events to avoid issues on resize
            $('.dropdown').off('mouseenter mouseleave');
        }
    }

    enableHoverDropdown();

    // Re-apply on window resize
    $(window).on('resize', function () {
        enableHoverDropdown();
    });
});



// AOS Init
$(document).ready(function() {
	AOS.init({
		duration: 1000,
	  });
  });


  const counters = document.querySelectorAll('.counter');

const speed = 200; 

counters.forEach(counter => {
    const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;

        const increment = target / speed;

        if (count < target) {
            counter.innerText = Math.ceil(count + increment);
            setTimeout(updateCount, 20);
        } else {
            counter.innerText = target.toLocaleString();
        }
    };

    updateCount();
});


