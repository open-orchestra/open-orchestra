// fire links with targets on menu to open
$(document).on('click', 'nav a[target="_menu"]', function(e) {
    e.preventDefault();
    $this = $(e.currentTarget);
    window.setTimeout(function() {
        if (!$this.hasClass('menu-opened')) {
            $this.addClass("menu-opened");
            
            $.ajax({
                type : "GET",
                url : $this.attr('href'),
                dataType : 'json',
                cache : false,
                success : function(data) {
                    var html = '';
                    for (var i = 0; i < data.length; i++) {
                        html += '<li><a href="' + data[i].url + '">' + data[i].label + '</a></li>'
                    }
                    $this.next().html(html);
                    return false;
                },
                error : function(xhr, ajaxOptions, thrownError) {
                    $this.next().html('<li><a href=""><i class="fa fa-times-circle"></i> Error</a></li>');
                },
                async : false
            });
            
        } else {
            $this.removeClass("menu-opened");
            $this.next().html('<li><a href="">Loading ...</a></li>');
        }
        
    }, 200);
});

// click on links inside content
$(document).on('click', '.tabLink', function(e) {
    e.preventDefault();
    orchestraAjaxLoad($(e.currentTarget).attr('href'));
});

// change a select switcher
$(document).on('change', '.selectSwitcher', function(e) {
    e.preventDefault();
    $this = $(e.currentTarget);
    
    if ($this.find("option:selected").attr('data-loadmode') == 'ajax') {
        orchestraAjaxLoad($this.val());
    } else {
        window.location.hash = $this.val();
    }
});

function displayLoader()
{
    $('#content').html('<h1><i class="fa fa-cog fa-spin"></i> Loading...</h1>');
    
    return true;
}

// Specific orchestra ajax loading
function orchestraAjaxLoad(url)
{
    displayLoader();
    $.post(url, function(response) {
        if (response.success) {
            window.location.hash = response.data;
        } else {
            $('#content').html(response.data);
        }
    });
}

function callAndReload(action)
{
    displayLoader();
    $.post(action, function(response) {
        if (response.success) {
            window.location.reload();
        }
    });
}

/*
 * LOAD CSS
 * Usage:
 * loadCss("css/my_lovely_css.css");
 */

var cssArray = {};

function loadCss(cssName) {
    if (!cssArray[cssName]) {
        cssArray[cssName] = true;
        
/*
        doc = doc || document;
        var head = doc.getElementsByTagName("head")[0];
        if (head && addRule) {
            var styleEl = doc.createElement("style");
            styleEl.type = "text/css";
            styleEl.media = "screen";
            head.appendChild(styleEl);
            addRule(selector, rule, styleEl, doc);
            styleEl = null;
        }*/
        
        // adding the css tag to the head as suggested before
        var body = document.getElementsByTagName('body')[0];
        var css = document.createElement('link');
        css.href = cssName;
        css.media = "screen";
        css.type = 'text/css';
        css.rel = 'stylesheet';
        // fire the loading
        body.appendChild(css);
    }
}

/* ~ END: LOAD SCRIPTS */
