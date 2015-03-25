String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, "");
};

Array.range = function(n) {
    // Array.range(5) --> [0,1,2,3,4]
    return Array.apply(null,Array(n)).map(function(x,i){
        return i
    });
};

Object.defineProperty(Array.prototype, 'chunk', {
    value: function(n) {
        // ACTUAL CODE FOR CHUNKING ARRAY:
        return Array.range(Math.ceil(this.length/n)).map(function(x,i) {
            return this.slice(i*n,i*n+n);
        }.bind(this));
    }
});

// Global Namespace
var w = window,
    $w = $(w),
    d = document,
    e = d.documentElement,
    b = d.getElementsByTagName("body")[0],
    $b = $(b),
    ch = w.ch = {};
    ch.b = $b;

ch.baseURL = baseURL; // from `outro.html`

ch.timing = {
    showImage: 5000
};

ch.sponsors = {
    showSponsorsEvery: 8,
    imageCountForSponsors: 0,
    currentSponsorIndex: 0,
    getSponsors: function () {
        $.ajax({
            url: ch.sponsors.sponsorsBaseUrl,
            dataType: "json"
        }).done(function (data) {
            ch.data.cachedSponsors = data.images;
            ch.sponsors.sponsorLength = ch.data.cachedSponsors.length;
        });
    },
    shouldShowSponsor: function() {
        return (ch.sponsors.imageCountForSponsors % ch.sponsors.showSponsorsEvery === 0) ? true : false;
    },
    addSponsor: function() {
        var avatarDOM = ch.display.avatarDOM;
            avatarDOM = avatarDOM.replace(/{{image}}/g, ch.data.cachedSponsors[ch.sponsors.currentSponsorIndex].image)
                             .replace(/{{author-full_name}}/g, ("@" + ch.data.cachedSponsors[ch.sponsors.currentSponsorIndex].author.username.trim()));
        
        ch.display.avatarContainer.find(".user:nth-child(" + ch.display.avatarsToShow + ")").after(avatarDOM);
        
        var instagramImageDOM = ch.display.imageDOM;
            instagramImageDOM = instagramImageDOM.replace(/{{image}}/g, ch.data.cachedSponsors[ch.sponsors.currentSponsorIndex].image)
                            .replace(/{{author-full_name}}/g, ch.data.cachedSponsors[ch.sponsors.currentSponsorIndex].author.full_name.trim());

        ch.display.imageContainer.find(".intrinsic:nth-child(" + (ch.display.avatarsToShow - 1) + ")").after(instagramImageDOM);

        ch.sponsors.currentSponsorIndex++;

        if (ch.sponsors.currentSponsorIndex == ch.sponsors.sponsorLength) {
            ch.sponsors.currentSponsorIndex = 0;
        }
    }
};

ch.sponsors.sponsorsBaseUrl = sponsorsBaseURL; // from `outro.html`


ch.display = {
    avatarContainer: $(".js-insert-avatars"),
    avatarDOM: '<div class="instagram__users__user user"><div class="user__avatar"><div class="intrinsic full"><div class="intrinsic__wrapper -ratio-1x1"><img class="intrinsic__wrapper__element" src="{{image}}" alt="{{author-full_name}}"  /></div></div></div><h2 class="user__name">{{author-full_name}}</h2></div>',
    imageContainer: $(".js-insert-image"),
    imageDOM: '<div class="intrinsic full"><div class="intrinsic__wrapper -ratio-1x1"><img class="intrinsic__wrapper__element" src="{{image}}" alt="{{author-full_name}}"></span></div></div>',
    avatarsToShow: 4,
    addAvatars: function(amountToDisplay) {
        for (var index in ch.data.currentSet) {
            var tempDOM = this.avatarDOM;
                tempDOM = tempDOM.replace(/{{image}}/g, ch.data.currentSet[index].author.avatar)
                                 .replace(/{{author-full_name}}/g, ("@" + ch.data.currentSet[index].author.username.trim()));

            this.avatarContainer.append(tempDOM);
        }
    },
    addCurrentImage: function(amountToPull) {
        for (var i in ch.data.currentSet) {
            var index = i,
                tempDOM = this.imageDOM;
                tempDOM = tempDOM.replace(/{{image}}/g, ch.data.currentSet[index].image)
                                .replace(/{{author-full_name}}/g, ch.data.currentSet[index].author.full_name.trim());

            this.imageContainer.append(tempDOM);
        }
    },
    init: function() {
        this.addAvatars();
        this.addCurrentImage();
    }
};

ch.timers = {
    currentIndex: 0,
    delay:  function(counter, fnc) {
        var delay = (counter || 500);
        if(condition){
        
        }
        else {
            setTimeout(fnc, delay); // check again in a second
        }
    },
    moveAvatars: function() {
        var avatarContainer = $(".js-insert-avatars"),
            firstAvatar = $(".js-insert-avatars .user:first-child"),
            notFirstavatar = $(".js-insert-avatars .user:not(:first-child)");
        
        avatarContainer.addClass("js-move-moveAvatars");
        
        notFirstavatar[0].addEventListener('webkitAnimationEnd', function(e) {
            firstAvatar.remove();
            avatarContainer.removeClass("js-move-moveAvatars");

        }, false);

        if (ch.sponsors.shouldShowSponsor()) {
            ch.sponsors.addSponsor();
        }

        if ( ch.display.avatarsToShow >= (ch.data.currentLength - ch.data.imageCount) ) {

            ch.data.get();
            ch.data.imageCount = 0;
            
        }
    },
    changeCurrentImage: function() {
        var showingImage = $(".js-insert-image .intrinsic:first-child");
        showingImage.addClass("js-hide-CurrentImage");
    
        showingImage[0].addEventListener('webkitTransitionEnd', function( event ) { 
            $(".js-hide-CurrentImage").remove();
            ch.timers.moveAvatars();
            ch.timers.currentImageResetTimer(true);
            ch.data.imageCount++;
            ch.sponsors.imageCountForSponsors++;
        }, false );
    },
    currentImageResetTimer: function (restart) {
        restart = (restart) ? true : false;

        clearInterval(this.currentImageTimerInterval);

        if (restart) {
            this.currentImageTimer();
        }
    },
    currentImageTimer: function() {
        this.currentImageTimerInterval = setInterval(function () {
            
            ch.timers.currentIndex++;

            ch.timers.changeCurrentImage();

        }, ch.timing.showImage);
    },
    init: function() {
        this.currentImageTimer();
        $(".js-insert-image .intrinsic:first-child").hide();
    }
};

ch.data = {
    imageCount: 0,
    get: function(amount, lastId) {
        $.ajax({
            url: ch.baseURL,
            dataType: "json",
            success: function (data) {
                console.log(data);

                ch.data.fullSet = data.images;
                ch.data.currentLength = data.images.length;
                ch.data.currentSet = data.images;

                ch.data.split();
            }
        });
    },
    split: function() {
        // this is where "chunking" can happen to get newest on top
            //var tempArray = ch.data.fullSet.chunk( ((this.isFirstTime) ? ch.display.avatarsToShow : 1) );
            //ch.data.currentSet = tempArray[0];
        
        if (this.isFirstTime) {
            ch.timers.currentImageTimer();
            this.isFirstTime = false;
        }
        
        ch.display.init();
    },
    init: function(isFirstTimeCalled) {
        this.isFirstTime = isFirstTimeCalled || false;
        this.get();

        if (this.isFirstTime) {
            ch.sponsors.getSponsors();
        }
    }
};


$(function() {
    ch.data.init(true);
});

