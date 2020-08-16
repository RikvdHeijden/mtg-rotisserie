<template>
    <div class="container" >
        <h1>{{ draft.set.name }} ( {{ player.name }} )</h1>

        <ul class="player-list">
            <li v-for="player in draft.players" class="player" :class="{'player--active': player.id === draft.activePlayer}">
                {{ player.name }} <span v-if="!player.active">(inactive)</span>
            </li>
        </ul>

        <div v-if="draft.started">
            <div class="search">
                <h3>search</h3>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="text" v-model="filters.search" class="form-control" id="search_text"/>
                    </div>
                </div>
                <div class="input-group">
                    <div v-for="(val, filter_color) in filters.filter_colors" class="form-check form-check-inline">
                        <input type="checkbox" v-model="filters.filter_colors[filter_color]" :id="`filter_color_${filter_color}`" :name="`filter_color_${filter_color}`" class="form-check-input" />
                        <label :for="`filter_color_${filter_color}`" class="form-check-label">{{ filter_color }}</label>
                    </div>
                </div>
                <div class="input-group">
                    <div v-for="(val, cmc) in filters.cmcs" class="form-check form-check-inline">
                        <input type="checkbox" v-model="filters.cmcs[cmc]" :id="`cmc_${cmc}`" :name="`cmc_${cmc}`" class="form-check-input"/>
                        <label :for="`cmc_${cmc}`" class="form-check-label">{{ cmc }}</label>
                    </div>
                </div>
                <div class="input-group">
                    <div v-for="(val, rarity) in filters.rarities" class="form-check form-check-inline">
                        <input type="checkbox" v-model="filters.rarities[rarity]" :id="`rarity_${rarity}`" :name="`rarity_${rarity}`" class="form-check-input"/>
                        <label :for="`rarity_${rarity}`" class="form-check-label">{{ rarity }}</label>
                    </div>
                </div>
            </div>

            <div style="display: flex; flex-wrap: wrap">
                <div
                    v-for="card in cards"
                    class="card"
                    @click="chooseCard(card)"
                >
                <span
                    v-if="getPick(card)"
                    class="card-picked"
                >
                    <span class="card-picked__text">Picked by {{ getPick(card).player.name }}</span>
                </span>
                    <img :src="card.normal_image" />
                </div>
            </div>

            <deck
                :picks="picks"
                :open="deckViewOpen"
                v-on:cardMoved="moveCard"
                v-on:openExporter="exporterOpen = true"
                v-on:toggleDeckView="deckViewOpen = !deckViewOpen"
                :key="deckKey"></deck>
            <export
                :picks="picks"
                :key="deckKey + 'exporter'"
                :open="exporterOpen"
                :setCode="draft.set.code"
                v-on:closeExporter="exporterOpen = false"
            ></export>
        </div>
        <div v-else>
            <h2>The draft is about to start!</h2>
            <p>People can join this draft with code <b>{{ draft.code }}</b> and the password the admin chose when they created the draft.</p>
            <p v-if="player.admin">
                Once everybody has joined you can start the draft. No more players can join the draft at that point, so be careful!
            </p>
            <button @click="startDraft" v-if="player.admin" class="btn btn-dark">Start!</button>
        </div>

        <div id="options" class="options">
            <div class="form-check">
                <input type="checkbox" v-model="options.addCardsToDeck" id="sb_option" class="form-check-input">
                <label for="sb_option" class="form-check-label">Add new cards to deck</label>
            </div>
            <button @click="leaveDraft" class="btn btn-sm btn-warning">Leave draft</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['config', 'playerdata'],

        data() {
            return {
                deckKey: 0,
                exporterOpen: false,
                deckViewOpen: false,
                options: {
                    addCardsToDeck: true,
                },
                filters: {
                    search: '',
                    cmcs: {
                        0: false,
                        1: false,
                        2: false,
                        3: false,
                        4: false,
                        5: false,
                        6: false,
                        '7+': false,
                    },
                    filter_colors: {
                        'W': false,
                        'U': false,
                        'B': false,
                        'R': false,
                        'G': false,
                        'C': false
                    },
                    rarities: {
                        'common': false,
                        'uncommon': false,
                        'rare': false,
                        'mythic': false,
                    },
                },
                player:  {
                    id: 1,
                    name: 'test'
                },
                draft: {
                    id: 1,
                    started: 0,
                    set: {
                        name: 'test',
                        code: 'tst',
                        cards: [
                            {
                                id: 1,
                                name: 'name',
                                text: 'text',
                                small_image: '',
                                normal_image: '',
                                large_image: '',
                                colors: '',
                                cmc: '',
                                type_line: '',
                                rarity: '',
                            }
                        ]
                    },
                    players: [
                        {
                            id: 1,
                            name: 'test'
                        }
                    ],
                    picks: [
                        {
                            player: {
                                id: 1,
                                name: 'test'
                            },
                            card_id: 1
                        }
                    ],
                    activePlayer: 1,
                },
                pickColumnMapping: {},
            }
        },

        computed: {
            cards: function () {
                return this.draft.set.cards.filter(card => {
                    let filtered = false;

                    if (this.filters.search) {
                        filtered = true;
                        const search = this.filters.search.toLowerCase().trim();

                        if (
                            card.name.toLowerCase().includes(search)
                            || card.text.toLowerCase().includes(search)
                            || card.type_line.toLowerCase().includes(search)
                        ) {
                            filtered = false;
                        }

                        if (filtered) {
                            return false;
                        }
                    }

                    if (Object.values(this.filters.cmcs).filter(x => x).length > 0) {
                        filtered = true;

                        Object.keys(this.filters.cmcs).forEach(k => {
                           if (this.filters.cmcs[k]) {
                               if (k === '7+' && card.cmc >= 7) {
                                   filtered = false;
                               }

                               if (card.cmc === k) {
                                   filtered = false;
                               }
                           }
                        });

                        if (filtered) {
                            return false;
                        }
                    }

                    if (Object.values(this.filters.filter_colors).filter(x => x).length > 0) {
                        filtered = true;

                        Object.keys(this.filters.filter_colors).forEach(k => {
                           if (this.filters.filter_colors[k]) {
                               if (k === 'C' && card.colors === '') {
                                   filtered = false;
                               }

                               if (card.colors.includes(k)) {
                                   filtered = false;
                               }
                           }
                        });

                        if (filtered) {
                            return false;
                        }
                    }

                    if (Object.values(this.filters.rarities).filter(x => x).length > 0) {
                        filtered = true;

                        Object.keys(this.filters.rarities).forEach(k => {
                           if (this.filters.rarities[k]) {
                               if (card.rarity === k) {
                                   filtered = false;
                               }
                           }
                        });

                        if (filtered) {
                            return false;
                        }
                    }

                    return !filtered;
                });
            },

            picks: function () {
                this.deckKey;
                return this.draft.picks
                    .filter(pick => pick.player.id === this.player.id)
                    .map(pick => {
                        pick.card = this.draft.set.cards.filter(card => card.id === pick.card_id)[0];
                        if (pick.card_id in this.pickColumnMapping) {
                            pick.column = this.pickColumnMapping[pick.card_id];
                        } else {
                            pick.column = Math.min(pick.card.cmc, 7);
                        }

                        return pick;
                    });
            }
        },

        mounted() {
            this.draft = JSON.parse(this.config);
            this.player = JSON.parse(this.playerdata);
            Echo.channel('draft.' + this.draft.id)
                .listen('CardPicked', this.refreshDraft);
        },

        methods: {
            chooseCard: function (card) {
                if (this.draft.activePlayer !== this.player.id) {
                    return;
                }

                if (this.getPick(card)) {
                    return;
                }

                axios.post(`/draft/${this.draft.id}/pick`, card).then(e => {
                    if (!this.options.addCardsToDeck) {
                        this.pickColumnMapping[card.id] = 'sb';
                    }
                });
            },

            getPick: function (card) {
                return this.draft.picks.filter(function (pick) {
                    return pick.card_id === card.id;
                })[0];
            },

            refreshDraft: function () {
                axios.get(`/drafts/${this.draft.code}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                }).then(res => {
                    this.draft = res.data.config;
                }).catch(error => {
                    console.error(error);
                })
            },

            moveCard: function(cardId, column) {
                const picks = this.draft.picks;

                picks.forEach(pick => {
                    if (pick.card_id == cardId && pick.player.id === this.player.id) {
                        this.pickColumnMapping[pick.card_id] = column;
                    }
                });

                this.deckKey++;
                this.draft.picks = picks;
            },

            updateOptions: function (options) {
                this.options = options;
            },

            leaveDraft: function () {
                if (window.confirm('Do you really want to leave this draft? Did you remember to export your deck to Arena?')) {
                    axios.delete(`/drafts/${this.draft.id}/leave`).then(e => {
                        window.location = '/';
                    });
                }
            },

            startDraft: function () {
                axios.put(`/drafts/${this.draft.id}/start`);
            }
        }
    }
</script>
