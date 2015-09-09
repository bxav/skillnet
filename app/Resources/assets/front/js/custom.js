/* Theme Name: The Project - Responsive Website Template
 * Author:HtmlCoder
 * Author URI:http://www.htmlcoder.me
 * Author e-mail:htmlcoder.me@gmail.com
 * Version:1.0.0
 * Created:March 2015
 * License URI:http://support.wrapbootstrap.com/
 * File Description: Place here your custom scripts
 */



$('#datetimepicker1').datetimepicker({
    locale: 'fr'
});

function loadAvailability(serviceId, date) {
    var xmlhttp = new XMLHttpRequest();
    var url = Routing.generate('availability', {'serviceId': serviceId, 'date': date });

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var text = xmlhttp.responseText;
            writeAvailability(text);
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function writeAvailability(text) {
    document.getElementById("id01").innerHTML = text;
}

function extractDate(datetime) {
    date = moment(datetime, "DD/MM/YYYY HH:mm").format('DD-MM-YYYY');
    return date;
}

document.getElementById("service-selector").onchange = function () {
    loadAvailability(this.value, extractDate(document.getElementById("datetime-selector").value));
};

document.getElementById("availability-checker").onclick = function () {
    loadAvailability(document.getElementById("service-selector").value, extractDate(document.getElementById("datetime-selector").value));
};
