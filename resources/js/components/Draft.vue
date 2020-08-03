<template>
    <div class="container">
        <h1>{{ draft.set.name }} ( {{ player.name }} )</h1>

        <ul>
            <li v-for="player in draft.players" :class="{'player--active': player.id === draft.activePlayer}">
                {{player.id}} {{ player.name }}
            </li>
        </ul>

        <div style="display: flex; flex-wrap: wrap">
            <div
                v-for="card in draft.set.cards"
                class="card"
                :class="{ 'card--picked': getPick(card) }"
                @click="chooseCard(card)"
            >
                <span
                    v-if="getPick(card)"
                >
                    Picked by {{ getPick(card).player.name }}
                </span>
                <div>{{ card.name }}</div>
                <p>{{ card.text }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['config', 'player'],

        data() {
            return {
                player:  {
                    id: 1,
                    name: 'test'
                },
                draft: {
                    id: 1,
                    set: {
                        name: 'test',
                        cards: [
                            {
                                id: 1,
                                name: 'name',
                                text: 'text'
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
                            card: 1
                        }
                    ],
                    activePlayer: 1,
                }
            }
        },

        mounted() {
            this.draft = JSON.parse(this.config);
            this.player = JSON.parse(this.player);
        },

        methods: {
            chooseCard: function (card) {
                if (this.draft.activePlayer !== this.player.id) {
                    return;
                }

                if (this.getPick(card)) {
                    return;
                }

                axios.post(`/draft/${this.draft.id}/pick`, card)
                    .then(res => {
                        this.draft = res.data;
                    })
            },

            getPick: function (card) {
                return this.draft.picks.filter(function (pick) {
                    return pick.card_id === card.id;
                })[0];
            }
        }
    }
</script>
