var adverts = {
    // Gazeti changes layout at 770px window width.
    responsiveBreak: 768,
    // The class of the actual advert within each group.
    advert: '.tuairisc-advert',
    fallback: {
        // Fallback media if an advert is missing an appropriate image.
        image : '//' + window.location.hostname + '/wp-content/uploads/tuairisc_fallback_desktop_.gif',
        href  : '//' + window.location.hostname + '/catnip.bhalash.com/glac-fograi-linn/',
        title : 'Tuairisc'
    },
    suffix: {
        // Suffix denotes respective desktop and mobile versions.
        desktop : '_desktop_',
        mobile  : '_mobile_'
    },
    banners: [
        // Banner advert groups.
        '.g-1',
        '.g-3'
    ],
    sidebar: [
        // Sidebar advert groups.
        '.g-2',
        '.g-4',
        '.g-5'
    ]
};

jQuery(function($) {
    $.each(adverts.banners, function(i,v) {
        console.log(i,v);
    });
 
    $.each(adverts.sidebar, function(i,v) {
        console.log(i,v);
    });
});
