<template>
    <div class="export" v-if="open">
        <div id="arena-export">
            <div v-for="pick in mainpicks">
                1 {{ pick.card.name }} ({{ setCode.toUpperCase() }}) {{ pick.card.collector_number }}
            </div>
            <br>
            <div v-for="pick in sideboard">
                1 {{ pick.card.name }} ({{ setCode.toUpperCase() }}) {{ pick.card.collector_number }}
            </div>
        </div>
        <button class="arena-export-button" id="arena-export-button" @click="copyToClipboard">Export</button>
        <button class="arena-export-button" @click="$emit('closeExporter')">Close</button>
    </div>
</template>

<script>
    export default {
        props: ['picks', 'open', 'setCode'],

        computed: {
            mainpicks: function() {
                return this.picks.filter(pick => pick.column !== 'sb');
            },
            sideboard: function() {
                return this.picks.filter(pick => pick.column === 'sb');
            }
        },

        methods: {
            copyToClipboard: function() {
                navigator.clipboard
                    .writeText(document.getElementById('arena-export').innerText.trim())
                    .then(e => {
                        document.getElementById('arena-export-button')
                            .classList.add('arena-export-button__success');
                    }, e => {
                        document.getElementById('arena-export-button')
                            .classList.add('arena-export-button__failed');
                    });
            }
        }
    }
</script>
