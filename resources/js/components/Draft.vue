<template>
    <div class="container">
        <h1>{{ draft.set.name }}</h1>

        <ul>
            <li v-for="player in draft.players">
                {{ player.name }}
            </li>
        </ul>

        <div style="display: flex; flex-wrap: wrap">
            <div v-for="card in draft.set.cards" style="width: 200px; height: 300px; background-color: brown; margin: 5px">
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
                                name: 'name',
                                text: 'text'
                            }
                        ]
                    },
                    players: [
                        {
                            name: 'test'
                        }
                    ],
                }
            }
        },

        mounted() {
            this.draft = JSON.parse(this.config);
        }
    }
</script>
