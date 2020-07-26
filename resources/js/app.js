import $ from 'jquery';
import 'bootstrap';
import Play from './play';


$(document).ready(() => {
    if($('.play-container').length) {
        const play = new Play();
        play.setListeners();
    }
});
