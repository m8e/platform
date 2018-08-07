import {Controller} from "stimulus"
import Flatpickr from "stimulus-flatpickr";
import rangePlugin from "flatpickr/dist/plugins/rangePlugin.js";
import "flatpickr/dist/l10n";

export default class extends Flatpickr  {

    initialize() {
        let plugins = [];
        if (this.data.get('range')) {
            plugins.push(new rangePlugin({ input: this.data.get('range')}))
        }
        
        this.config = {
            locale: document.documentElement.lang,
            "plugins": plugins,
        };
    }

    connect() {
        super.connect();

    }

    change(selectedDates, dateStr, instance) {
        return dateStr;
    }
}