import axios from 'axios';
import Vue from 'vue';

import * as currencyMap from  './currency-map';

let timeout = null;

new Vue({
    el: '#Calculator',
    data() {
        return {
            value: '',
            from: null,
            to: null,
            result: null,
            currencies: [],
            currencyMap: {}
        }
    },
    mounted() {
        axios.post('/currencies')
            .then(response => {
                this.currencies = response.data
            });
    },
    methods: {
        setValue(e) {
            const num = e.target.value.replace(/[^.\d]/g, "");
            if(num === '.') {
                this.value = '';
            } else if(num.match(/^\d+\./)) {
                this.value = parseInt(num).toLocaleString() + num.slice(num.indexOf('.'))
            } else {
                this.value = num ? parseInt(num).toLocaleString() : '';
            }
            if(timeout) {
                clearTimeout(timeout);
                timeout = null;
            }
            timeout = setTimeout(this.calc, 500);
        },
        setFrom(e) {
            for(let item of this.currencies) {
                if(item.currency === e.target.value) {
                    this.from = item;
                    break;
                }
            }
            this.calc();
        },
        setTo(e) {
            for(let item of this.currencies) {
                if(item.currency === e.target.value) {
                    this.to = item;
                    break;
                }
            }
            this.calc();
        },
        reverse() {
            if(this.from && this.to) {
                const from = this.from;
                this.from = this.to;
                this.to = from;
                this.calc();
            }
        },
        calc() {
            if(this.value && this.from && this.to) {
                axios.post('/calc', {
                    value: parseFloat(this.value.toString().replace(/\s+/, '')),
                    from: this.from.currency,
                    to: this.to.currency}
                ).then(response => {
                    const data = response.data;
                    const value =    data.value.toLocaleString();
                    const diff = {
                        from: '1 ' + currencyMap[this.from.currency].symbol_native,
                        to: data.diff.toLocaleString() + ' ' + currencyMap[this.to.currency].symbol_native
                    };

                    this.result = {
                        value: value + ' ' + currencyMap[this.to.currency].symbol_native,
                        diff: diff
                    }

                });
            }
        }
    },
    template: `
        <div class="calc__content">
            <div class="calc__form">
                <label class="calc__input">
                    <span>Обменять</span>
                    <input v-model="value" @keyup="setValue"/>
                </label>
                <div class="calc__control">
                    <label class="calc__input calc__input_select">
                        <span>Из</span>
                        <select @change="setFrom">
                            <option disabled selected/>
                            <template v-for="item of currencies">
                                <option v-if="item !== to" :value="item.currency" :selected="from && from.currency === item.currency">{{item.currency}}</option>
                            </template>
                        </select>
                    </label>
                    <button class="calc__reverse" @click="reverse"/>
                    <label class="calc__input calc__input_select">
                        <span>В</span>
                        <select @change="setTo">
                            <option disabled selected/>
                            <template v-for="item of currencies">
                                <option v-if="item !== from" :value="item.currency" :selected="to && to.currency === item.currency">{{item.currency}}</option>
                            </template>
                        </select>
                    </label>
                </div>
            </div>
            <div class="calc__result" v-if="result">
                <p>Вы получите</p>
                <b>{{result.value}}</b>
                <p class="calc__desc">{{result.diff.from}} = {{result.diff.to}} </p>
            </div>
        </div>
    `
});

