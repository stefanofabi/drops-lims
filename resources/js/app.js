import './bootstrap';

import * as bootstrap from '~bootstrap';
window.bootstrap = bootstrap;

import $ from 'jquery';
window.$ = $;

import '@fortawesome/fontawesome-free/js/all.js';

import "~datatables.net-bs5";

import '~@tarekraafat/autocomplete.js/dist/autoComplete.js';

import { GoogleCharts } from '~google-charts';
window.GoogleCharts = GoogleCharts;

import 'tinymce/tinymce';
import 'tinymce/plugins/table/plugin';
import 'tinymce/plugins/code/plugin';
import 'tinymce/plugins/lists/plugin';
import 'tinymce/plugins/wordcount/plugin';
import 'tinymce/plugins/searchreplace/plugin';
import 'tinymce/plugins/quickbars/plugin';
import 'tinymce/plugins/preview/plugin';
import 'tinymce/plugins/link/plugin';
import 'tinymce/plugins/fullscreen/plugin';
import 'tinymce/plugins/emoticons/plugin';
import 'tinymce/plugins/emoticons/js/emojis';
import 'tinymce/plugins/charmap/plugin';
import 'tinymce/plugins/advlist/plugin';
import 'tinymce/themes/silver/theme';
import 'tinymce/icons/default/icons';
import 'tinymce/models/dom/model';

import '../sass/app.scss'
