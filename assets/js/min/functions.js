!function(e,t,n){var o=function(n){var o=this;o.breaks={width:640},o.state={search:ko.observable(n),menu:ko.observable(!0),menuButton:ko.observable(!1)},o.showSearch=function(){o.state.search(!o.state.search())},o.showMenu=function(){o.state.menu(!o.state.menu())},o.keyupHide=function(e,t){27===t.keyCode&&(o.state.search(!1),o.state.menu(!1))},o.onscrollHide=function(){o.state.menu(!1)},o.scrollToggle=function(){var n=e(t).scrollTop(),s=e("#main").offset().top;o.state.menu()&&(n-=e("#header").height()),n>=s&&o.state.menu()?(o.state.menu(!1),o.state.menuButton(!0)):s>n&&!o.state.menu()&&(o.state.menu(!0),o.state.menuButton(!1))},o.sizeToggle=function(){e(t).width()<=o.breaks.width?(o.state.menuButton(!0),o.state.menu(!1),e(t).off("scroll",o.scrollToggle)):e(t).on("scroll",o.scrollToggle).trigger("scroll")},e(t).on("resize",o.sizeToggle).trigger("resize")};ko.applyBindings(new o(!1))}(jQuery,window,document),function(e,t,n,o,s,a,r){e.GoogleAnalyticsObject=s,e[s]=e[s]||function(){(e[s].q=e[s].q||[]).push(arguments)},e[s].l=1*new Date,a=t.createElement(n),r=t.getElementsByTagName(n)[0],a.async=1,a.src=o,r.parentNode.insertBefore(a,r)}(window,document,"script","//www.google-analytics.com/analytics.js","ga"),ga("create","UA-55288923-1","auto"),ga("send","pageview");