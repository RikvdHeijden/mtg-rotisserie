<template>
    <div class="deck" v-bind:style="{ height: open ? '500px' : '60px', overflowY: open ? 'scroll' : 'none'}">
        <h2>Deck
            <button @click="$emit('toggleDeckView')" class="btn btn-outline-dark" style="float: right" v-html="open ? 'V' : '^'"></button>
        </h2>
        <button @click="$emit('openExporter')" class="btn btn-sm btn-info">Export</button>

        <div class="deck-column-container">
            <div class="deck-column" v-for="(columnPicks, column) in columns" :id="`column-${column}`" @dragover="$event.preventDefault()" @dragenter="$event.preventDefault()" @drop="registerDrop(column, $event)">
                <div v-for="pick in columnPicks" class="deck__card" draggable="true" @dragstart="registerDrag(pick.id, $event)">
                    <img :src="pick.small_image"/>
                </div>
            </div>
            <div class="deck-column deck-column--sideboard" :id="`sideboard`" @dragover="$event.preventDefault()" @dragenter="$event.preventDefault()" @drop="registerDrop('sb', $event)">
                <h3>Sideboard</h3>
                <div v-for="pick in sideboard" class="deck__card" draggable="true" @dragstart="registerDrag(pick.card.id, $event)">
                    <img :src="pick.card.small_image"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['picks', 'open'],

        computed: {
            columns: function() {
                let columns = {0: [], 1: [], 2: [], 3: [], 4: [], 5:[], 6: [], 7: []};

                this.picks.forEach(pick => {
                    if (pick.column !== 'sb') {
                        columns[pick.column].push(pick.card);
                    }
                });

                return columns;
            },
            sideboard: function() {
                return this.picks.filter(pick => pick.column === 'sb');
            }
        },

        methods: {
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
