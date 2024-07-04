require('./bootstrap');
import $ from 'jquery';
import 'jquery-ui/ui/widgets/sortable';
import 'jquery-ui/ui/widgets/mouse'; // Ensure this is also imported
import 'jquery-ui/ui/disable-selection'; // Import the disableSelection method
window.$ = window.jQuery = $;
