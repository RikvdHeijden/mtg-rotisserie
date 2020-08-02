<template>
    <div class="container">
        <h1>{{ draft.set.name }}</h1>

        <ul>
            <li v-for="player in draft.players" :class="{'player--active': player.id === draft.activePlayer}">
                {{player.id}} {{ player.name }}
            </li>
        </ul>

        <div style="display: flex; flex-wrap: wrap">
            <div
                v-for="card in draft.set.cards"
                style="width: 200px; height: 300px; background-color: brown; margin: 5px"
                @click="chooseCard(card)"
            >
                <div>{{ card.name }}</div>
                <p>{{ card.text }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['config'],

        data() {
            return {
                draft: {
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
                    activePlayer: 1,
                }
            }
        },

        mounted() {
            this.draft = JSON.parse(this.config);
            console.log(this.draft.activePlayer);
        },

        methods: {
            chooseCard: function (card) {
                axios.post('/draft/1/pick', card)
                    .then(res => {
                        this.draft = res.data;
                    })
            }
        }
    }
</script>
