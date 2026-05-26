document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.sort-wrapper.custom-dropdown').forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const items = dropdown.querySelectorAll('.dropdown-list li');
        const input = dropdown.querySelector('input[type="hidden"]');

        if (!toggle || !items.length || !input) return;

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });

        items.forEach(item => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();

                const value = this.dataset.value || '';
                input.value = value;

                dropdown.classList.remove('open');

                const url = new URL(window.location.href);

                if (value) {
                    url.searchParams.set('sort', value);
                } else {
                    url.searchParams.delete('sort');
                }
                window.location.href = url.toString();
            });
        });

        document.addEventListener('click', function () {
            dropdown.classList.remove('open');
        });
    });
});

new Swiper(".collage-slider", {
    slidesPerView: "auto",
    spaceBetween: -50,
    grabCursor: true,
    loop: false,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
    },
    breakpoints: {
        768: {
            spaceBetween: -80,
            navigation: {
                nextEl: ".button-next",
                prevEl: ".button-prev"
            },
        },
    }
});

//-------------Sort Filter-----------------
const sortWrapper = document.querySelector(".sort-wrapper");
const sortButton = document.querySelector(".sort-icon");

if (sortButton && sortWrapper) {
    sortButton.addEventListener("click", function (e) {
        e.stopPropagation();
        sortWrapper.classList.toggle("open");
    });


    document.addEventListener("click", function () {
        sortWrapper.classList.remove("open");
    });

}

//-------------Active class for filter Dropdown menu------------------
const params = new URLSearchParams(window.location.search);
const activeValues = [];
params.forEach((value) => {
    if (value) activeValues.push(value);
});

document.querySelectorAll('.dropdown-list li').forEach(li => {
    const liValue = li.getAttribute('data-value');

    li.classList.remove('active');

    if (liValue && activeValues.includes(liValue)) {
        li.classList.add('active');
    }
});


//-----------Product/recipe Filter---------------
jQuery(document).ready(function ($) {

    var mobileMode = $(window).width() < 1024;

    forceDropdownVisibility();

    function isMobile() {
        return mobileMode;
    }

    function forceDropdownVisibility() {
        $('.custom-dropdown').each(function () {
            var $dd = $(this);
            var $list = $dd.find('.dropdown-list');

            if (isMobile()) {
                if ($dd.hasClass('open')) {
                    $list.show();
                } else {
                    $list.hide();
                }
            } else {
                if ($dd.hasClass('open')) {
                    $list.show();
                } else {
                    $list.hide();
                }
            }
        });
    }

    $('.custom-dropdown').each(function () {
        var $dropdown = $(this);
        var $toggle = $dropdown.find('.dropdown-toggle');
        var $label = $dropdown.find('.dropdown-label');
        var $input = $dropdown.find('input[type="hidden"]');
        var $list = $dropdown.find('.dropdown-list');
        var $items = $dropdown.find('li');

        $toggle.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (isMobile()) {
                var willBeOpen = !$dropdown.hasClass('open');

                $('.custom-dropdown').not($dropdown)
                    .removeClass('open active')
                    .find('.dropdown-list').slideUp(220);

                $dropdown.toggleClass('open');
                $toggle.toggleClass('active');
                $list.slideToggle(220);
            } else {

                var willBeOpen = !$dropdown.hasClass('open');
                $('.custom-dropdown').not($dropdown).removeClass('open').find('.dropdown-list').hide();
                $dropdown.toggleClass('open');

                forceDropdownVisibility();
            }
        });

        $items.on('click', function (e) {
            e.stopPropagation();

            var $item = $(this);
            var value = $item.data('value') || '';
            var text = $item.text().trim();

            $label.text(text);
            $input.val(value);

            $dropdown.removeClass('open');
            $toggle.removeClass('active');

            if (isMobile()) {
                $list.slideUp(180);
            } else {
                $list.hide();
            }

            var $form = $dropdown.closest('form');
            if ($form.length) {
                $form.submit();
            }
        });
    });

    $(document).on('click', function (e) {
        if (!isMobile() && !$(e.target).closest('.custom-dropdown').length) {
            $('.custom-dropdown').removeClass('open');
            $('.dropdown-toggle').removeClass('active');
            $('.dropdown-list').hide();
        }
    });

    $(window).on('resize', function () {
        var nowMobile = $(window).width() < 1024;

        if (nowMobile !== mobileMode) {
            mobileMode = nowMobile;

            if (nowMobile) {
                $('.custom-dropdown.open').each(function () {
                    var $dd = $(this);
                    $dd.find('.dropdown-list').hide();
                    if (!$dd.find('.dropdown-toggle').hasClass('active')) {
                        $dd.removeClass('open');
                    }
                });
            } else {
                $('.dropdown-toggle').removeClass('active');
            }

            forceDropdownVisibility();
        }
    });

    $('.filter-toggle').on('click', function (e) {
        e.preventDefault();
        $('.product-filters').toggleClass('is-open open');
    });

    $('.close-filter').on('click', function (e) {
        e.preventDefault();
        $('.product-filters').removeClass('is-open open');
    });

});
