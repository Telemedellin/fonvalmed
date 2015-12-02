/**
  Copyright (C) <2015>  Vasyl Martyniuk <vasyl@vasyltech.com>

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */

(function ($) {
    $(document).ready(function () {

        //init editor
        var editor = CodeMirror.fromTextArea(
                document.getElementById("configpress"), {
                    lineNumbers: true
                }
        );

        //init save btn
        $('#save-configurations').bind('click', function (event) {
            event.preventDefault();

            $.ajax(configPress.baseurl, {
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'configpress',
                    config: editor.getValue(),
                    _ajax_nonce: configPress.nonce
                },
                beforeSend: function () {
                    $('.spinner').css('visibility', 'visible');
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $('.status').attr('class', 'status success');
                    } else {
                        $('.status').attr('class', 'status failure');
                    }
                    
                    $('.error-message', '.config-area').html(response.error);
                    
                    $('.status').css('visibility', 'visible');
                },
                error: function () {
                    $('.status').attr('class', 'status failure');
                },
                complete: function () {
                    $('.spinner').css('visibility', 'hidden');
                    setTimeout(function() {
                        $('.status').css('visibility', 'hidden');
                    }, 5000);
                }
            });
        });
    });
})(jQuery);