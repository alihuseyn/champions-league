import $ from 'jquery';
import ajax from './request';

class Play {
  constructor() {
    this.$alert = $('.alert-container');

    this.$menu = {
      start: $('div[data-menu="start"]'),
      general: $('div[data-menu="general"]'),
    };

    this.$container = {
      league: $('div[data-container="league"]'),
      main: $('div[data-container="main"]'),
      prediction: $('div[data-container="prediction"]'),
    }

    this.$btn = {
      play: $('button[data-btn="play"]'),
      reset: $('button[data-btn="reset"]'),
      next: $('button[data-btn="next"]'),
      all: $('button[data-btn="all"]')
    };

    this.$controller = {
      matches: $('div[data-controller="matches"]'),
      league: $('tbody[data-controller="league"]'),
    };
  }
  setListeners() {
    this.$btn.play.on('click', this.play.bind(this));
    this.$btn.reset.on('click', this.reset.bind(this));
    this.$btn.next.on('click', this.nextWeek.bind(this));
    this.$btn.all.on('click', this.playAll.bind(this));
  }
  play() {
    ajax.post('/play').then(response => {
      this._updateMenuBar();
      this._updateMatchTable(response.league);
      this._updateMatchResult(response.matches);
    }).catch(({ error }) => {
      this.showAlert(error, 'danger');
    });
  }
  reset() {
    ajax.post('/reset').then(response => {
      this._updateMenuBar();
      this._updateMatchTable(response);
      this._updateMatchResult();
      if (this.interval) {
        clearInterval(this.interval);
        this.$btn.all.attr('disabled', false);
        this.$btn.next.attr('disabled', false);
      }
      this.$container.league.removeClass('col-lg-8');
      this.$container.prediction.remove();
      this.$alert.html('');
    });
  }
  showAlert(message, type) {
    this.$alert.html(`
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-triangle mr-1"></i> ${message}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
    `);
  }
  nextWeek() {
    ajax.post('/nextWeek').then(response => {
      this._updateMatchTable(response.league);
      this._updateMatchResult(response.matches);
      this._updatePredictionTable(response.predictions);
    }).catch(({ error }) => {
      this.showAlert(error, 'danger');
    });
  }
  playAll() {
    this.$btn.all.attr('disabled', true);
    this.$btn.next.attr('disabled', true);
    this.interval = setInterval(() => {
      ajax.post('/nextWeek').then(response => {
        this._updateMatchTable(response.league);
        this._updateMatchResult(response.matches);
        this._updatePredictionTable(response.predictions);
      }).catch(({ error }) => {
        clearInterval(this.interval);
        this.$btn.all.attr('disabled', false);
        this.$btn.next.attr('disabled', false);
      });
    }, 2000);
  }
  _updateMenuBar() {
    if (!this.$menu.start.hasClass('d-none')) {
      this.$menu.start.addClass('d-none');
      this.$menu.general.addClass('d-flex');
      this.$menu.general.removeClass('d-none');
    } else {
      this.$menu.general.addClass('d-none');
      this.$menu.general.removeClass('d-flex');
      this.$menu.start.removeClass('d-none');
    }
  }
  _updateMatchResult(matches) {
    if (matches) {

      let week = matches[0].week;
      week = week == 1 ? '1st' : (week == 2 ? '2nd' : (week == 3 ? '3rd' : `${week}th`));

      const _template = matches.map(it => {
        return `<div class="match">
          <span class="text-left">${it.home.name}</span>
          <span class="text-center">${ it.home_team_score } - ${ it.away_team_score }</span>
          <span class="text-right">${it.away.name}</span>
        </div>`;
      })

      this.$controller.matches.html(`
        <div class="text-center">
          <span>
            ${week} Week Match Result
          </span>
        </div>
        <div class="matches">
            ${_template.join('')}
        </div>
        `
      );
    } else {
      this.$controller.matches.html(`
      <p class="text-center">
        <b>
          <i class="fas fa-info-circle"></i>
          League Not Started Yet
        </b>
      </p>
      `);
    }
  }
  _updateMatchTable(league) {
    const _template = league.map(it => {
      return `<tr>
        <td scope="col">${it.team.name}</td>
        <td scope="col">${it.points}</td>
        <td scope="col">${it.played}</td>
        <td scope="col">${it.won}</td>
        <td scope="col">${it.draw}</td>
        <td scope="col">${it.lose}</td>
        <td scope="col">${it.goal_difference}</td>
      </tr>`;
    });

    this.$controller.league.html(_template);
  }
  _updatePredictionTable(predictions) {
    if (predictions) {
      let week = predictions[0].week;
      week = week == 1 ? '1st' : (week == 2 ? '2nd' : (week == 3 ? '3rd' : `${week}th`));

      let _template = predictions.map(it => {
        return `
          <div class="d-flex justify-content-between">
            <span>${it.team}</span>
            <span>${it.prediction}%</span>
          </div>
        `;
      });

      this.$container.league.addClass('col-lg-8');
      _template = `<div class="bg-white border p-2">
          <p class="text-center">${week} Week Predictions of Championship</p>
          <div>${_template.join('')}</div>
        </div>
      `;

      if (document.querySelector('div[data-container="prediction"]')) {
        this.$container.prediction.html(_template);
      } else {
        this.$container.main.append(
          `<div class="col-12 col-lg-4" data-container="prediction">
            ${_template}
          </div>
        `);
        this.$container.prediction = $('div[data-container="prediction"]');
      }
    }
  }
}

export default Play;
