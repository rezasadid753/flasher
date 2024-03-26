        <div id="bottom"></div>
    </div>
    <footer>
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 12C9.31371 12 12 9.31371 12 6C12 2.68629 9.31371 0 6 0C2.68629 0 0 2.68629 0 6C0.00358594 9.31223 2.68777 11.9964 6 12ZM3.525 3.525C4.89288 2.16047 7.10712 2.16047 8.475 3.525C8.66684 3.72363 8.66133 4.04016 8.46272 4.23199C8.26896 4.41914 7.96177 4.41914 7.76801 4.23199C6.79158 3.25582 5.20866 3.25601 4.23248 4.23246C3.25631 5.20891 3.2565 6.79181 4.23295 7.76798C5.20922 8.74399 6.79177 8.74399 7.76803 7.76798C7.96666 7.57615 8.28319 7.58166 8.47502 7.78029C8.66215 7.97405 8.66215 8.28122 8.47502 8.475C7.10813 9.8419 4.89192 9.8419 3.52502 8.475C2.1581 7.1081 2.1581 4.8919 3.525 3.525Z" fill="#FF0099"/></svg>
        Flasher
    </footer>
    <script>
        // Popup Menu
        document.addEventListener("DOMContentLoaded", function() {
            const openMenuBtn = document.querySelector('.openmenu');
            const closeMenuBtn = document.querySelector('.closemenu');
            const overlay = document.querySelector('.overlay');
            const menuPopup = document.querySelector('.menupopup');
            openMenuBtn.addEventListener('click', function() {
                closeMenuBtn.classList.add('showclose');
                overlay.classList.add('showoverlay');
                menuPopup.classList.add('showpopup');
            });
            closeMenuBtn.addEventListener('click', function() {
                closeMenuBtn.classList.remove('showclose');
                overlay.classList.remove('showoverlay');
                menuPopup.classList.remove('showpopup');
            });
        });

        // Center Container
        setInterval(function() {
            var totalHeight = 0;
            $(".container").children().each(function(){
                totalHeight += $(this).outerHeight(true);
            });
            var heightLimit = window.innerHeight - 170;
            if (totalHeight < heightLimit) {
                document.querySelector('.container').classList.add('containercenter');
            } else {
                document.querySelector('.container').classList.remove('containercenter');
            }
        }, 500);

        // Copy code
        document.addEventListener('DOMContentLoaded', function () {
            var codeTags = document.querySelectorAll('code');
            codeTags.forEach(function (codeTag) {
                codeTag.addEventListener('click', function () {
                    var textToCopy = codeTag.innerText;
                    navigator.clipboard.writeText(textToCopy)
                    .then(function () {
                        document.querySelector('.fncmsgsuccess').classList.add('showmsg');
                        // Remove the class after 4 seconds
                        setTimeout(function () {
                            document.querySelector('.fncmsgsuccess').classList.remove('showmsg');
                        }, 3000);
                    })
                    .catch(function (error) {
                        // Add class for failure message
                        document.querySelector('.fncmsgfail').classList.add('showmsg');
                        // Remove the class after 4 seconds
                        setTimeout(function () {
                            document.querySelector('.fncmsgfail').classList.remove('showmsg');
                        }, 3000);
                    });
                });
            });
        });

        // Show error when limited action is performed
        var limitedElements = document.querySelectorAll('.limited');
        limitedElements.forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                var limitMsg = document.querySelector('.limitmsg');
                limitMsg.classList.add('showmsg');
                var selectDropdown = element.closest('select');
                if (selectDropdown) {
                    selectDropdown.disabled = true;
                }
                setTimeout(function() {
                    limitMsg.classList.remove('showmsg');
                    if (selectDropdown) {
                        selectDropdown.disabled = false;
                    }
                }, 3000);
            });
        });

        // Show quick scroll buttons
        window.addEventListener('load', function() {
            checkContentHeight();
        });
        function checkContentHeight() {
            const scrollbars = document.querySelectorAll('.scrollbar');
            scrollbars.forEach(function(scrollbar) {
                const content = scrollbar.closest('.content');
                if (content.offsetHeight > 150 * window.innerHeight / 100) {
                    scrollbar.classList.add('showscrollbar');
                } else {
                    scrollbar.classList.remove('showscrollbar');
                }
            });
        }
    </script>
</body>
</html>