<template>
    <div class="deck" v-bind:style="{ height: open ? '500px' : '30px' }">
        <h2>DECKTIME
            <button @click="toggleState" style="float: right" v-html="open ? 'V' : '^'"></button>
        </h2>

        <div class="deck-column-container">
            <div class="deck-column" v-for="(columnPicks, column) in columns" :id="`column-${column}`" @dragover="$event.preventDefault()" @dragenter="$event.preventDefault()" @drop="registerDrop(column, $event)">
                <div v-for="pick in columnPicks" class="deck__card" draggable="true" @dragstart="registerDrag(pick.id, $event)">
                    <img :src="pick.small_image"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['picks'],

        data() {
            return {
                open: true,
            }
        },

        computed: {
            columns: function() {
                let columns = {0: [], 1: [], 2: [], 3: [], 4: [], 5:[], 6: [], 7: [], 8: []};

                this.picks.forEach(pick => {
                    columns[pick.column].push(pick.card);
                });

                return columns;
            }
        },

        methods: {
            toggleState: function () {
                this.open = !this.open;
            },

            registerDrop: function (column, e) {
                e.preventDefault();
                const cardId = e.dataTransfer.getData('card');

                this.$emit('cardMoved', cardId, column);
                this.$forceUpdate();
            },

            registerDrag: function (id, e) {
                e.dataTransfer.setData('card', id);
            }
        }
    }
</script>
