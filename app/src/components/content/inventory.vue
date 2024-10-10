<template>
    <div class="defaultContainer inventoryEssetials">
        <div class="innerContainer wealthContainer">
            <div class="containerRow">
                <span>Platinum</span>
                <span>
                    <input type="text" v-model="localCharacter.wealth.platinum" @input="updateCharacterData">
                </span>
            </div>
            <div class="containerRow">
                <span>Gold</span>
                <span>
                    <input type="text" v-model="localCharacter.wealth.gold" @input="updateCharacterData">
                </span>
            </div>
            <div class="containerRow">
                <span>Silver</span>
                <span>
                    <input type="text" v-model="localCharacter.wealth.silver" @input="updateCharacterData">
                </span>
            </div>
            <div class="containerRow">
                <span>Copper</span>
                <span>
                    <input type="text" v-model="localCharacter.wealth.copper" @input="updateCharacterData">
                </span>
            </div>
        </div>
        <div class="innerContainer rationContainer">
            <div class="containerRow">
                <span class="rationTitle">Rations</span>
                <span>
                </span>
            </div>
            <div class="containerRow">
                <span>Wealthy</span>
                <span>
                    <input type="text" v-model="localCharacter.rations.wealthy" @input="updateCharacterData">
                </span>
            </div>
            <div class="containerRow">
                <span>Comfortable</span>
                <span>
                    <input type="text" v-model="localCharacter.rations.comfortable" @input="updateCharacterData">
                </span>
            </div>
            <div class="containerRow">
                <span>Whack</span>
                <span>
                    <input type="text" v-model="localCharacter.rations.whack" @input="updateCharacterData">
                </span>
            </div>
        </div>
    </div>
    <div class="inventory">
        <div class="inventoryContainer weaponTable">
            <h3>Weapons</h3>
            <div class="interactiveTable">
                <div class="interactiveTableRow" v-for="(weapon, index) in localCharacter.inventory.weapons">
                    <input class="interactiveTableTitle" v-model="weapon.title" @input="updateCharacterData">
                    <span class="interactiveTableName input-sizer stacked" :data-value="weapon.name">
                        <textarea v-model="weapon.name" oninput="this.parentNode.dataset.value = this.value"
                            @input="updateCharacterData" rows="1"></textarea>
                    </span>
                    <div class="removeStatus" @click="deleteTableRow(index, localCharacter.inventory.weapons)">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <div class="interactiveTableRow addRow" @click="addTableRow(localCharacter.inventory.weapons)">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>
        </div>
        <div class="inventoryContainer clothTable">
            <h3>Cloths</h3>
            <div class="interactiveTable">
                <div class="interactiveTableRow" v-for="(cloth, index) in localCharacter.inventory.cloths">
                    <input class="interactiveTableTitle" v-model="cloth.title" @input="updateCharacterData">
                    <span class="interactiveTableName input-sizer stacked" :data-value="cloth.name">
                        <textarea v-model="cloth.name" oninput="this.parentNode.dataset.value = this.value"
                            @input="updateCharacterData" rows="1"></textarea>
                    </span>
                    <div class="removeStatus" @click="deleteTableRow(index, localCharacter.inventory.cloths)">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <div class="interactiveTableRow addRow" @click="addTableRow(localCharacter.inventory.cloths)">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>
        </div>
        <div class="inventoryContainer accessoriesTable">
            <h3>Accessories</h3>
            <div class="interactiveTable">
                <div class="interactiveTableRow" v-for="(accessory, index) in localCharacter.inventory.accessories">
                    <input class="interactiveTableTitle" v-model="accessory.title" @input="updateCharacterData">
                    <span class="interactiveTableName input-sizer stacked" :data-value="accessory.name">
                        <textarea v-model="accessory.name" oninput="this.parentNode.dataset.value = this.value"
                            @input="updateCharacterData" rows="1"></textarea>
                    </span>
                    <div class="removeStatus" @click="deleteTableRow(index, localCharacter.inventory.accessories)">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <div class="interactiveTableRow addRow" @click="addTableRow(localCharacter.inventory.accessories)">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>
        </div>
        <div class="inventoryContainer backpackTable">
            <h3>Inventory</h3>
            <div class="interactiveTable">
                <div class="interactiveTableRow" v-for="(inventorySlot, index) in localCharacter.inventory.backpack">
                    <input class="interactiveTableTitle" :value="index+1" @input="updateCharacterData" readonly>
                    <span class="interactiveTableName input-sizer stacked" :data-value="inventorySlot.name">
                        <textarea v-model="inventorySlot.name" oninput="this.parentNode.dataset.value = this.value" @input="updateCharacterData" rows="1"></textarea>
                    </span>
                    <div class="removeStatus" @click="deleteTableRow(index, localCharacter.inventory.backpack)">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <div class="interactiveTableRow addRow" @click="addTableRow(localCharacter.inventory.backpack)">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref, watch, defineEmits } from 'vue';

const props = defineProps({
    characterData: {
        type: Object,
        required: true
    }
});

const localCharacter = ref(props.characterData);

watch(localCharacter, (newVal) => {
    localCharacter.value = newVal;
    props.characterData = newVal
});

const emit = defineEmits(['update:characterData']);

function updateCharacterData(event) {
    const newSize = Number(event.target.value);
    emit('update:characterData', newSize);
}

const deleteTableRow = (index, tableContents) => {
    tableContents.splice(index, 1)
    emit('update:characterData');
}

const addTableRow = (tableContents) => {
    tableContents.push({
        title: '',
        name: '',
    })
    emit('update:characterData');
}
</script>

<style scoped lang="scss">
.inventoryEssetials {
    display: flex;
    flex-direction: row;
    gap: 20px;

    .wealthContainer {
        background-color: var(--colorWealth);
    }

    .rationContainer {
        background-color: var(--colorRations);
    }

    .innerContainer {
        width: 100%;

        input {
            width: 100%;
        }

        .containerRow {
            display: flex;

            span {
                display: block;
                width: 50%;

                &:nth-child(2) {
                    color: var(--colorWhite);
                    font-weight: normal;
                }
            }

            .rationTitle {
                color: var(--colorWhite);
            }
        }
    }
}
.inventoryContainer {
   margin-top: 40px;
    .interactiveTable {
        display: flex;
        flex-direction: column;
        margin-top: 10px;

        .interactiveTableRow {
            display: flex;
            flex-direction: row;
            min-height: 20px;

            &:nth-child(1) .interactiveTableTitle {
                border-radius: 6px 0 0 0;
            }

            &:nth-child(1) .interactiveTableName {
                border-radius: 0 6px 0 0;
            }

            &:nth-last-child(2) .interactiveTableTitle {
                border-radius: 0 0 0 6px;
            }

            &:nth-last-child(2) .interactiveTableName {
                border-radius: 0 0 6px 0;
            }

            &:not(:nth-last-child(2)) .interactiveTableTitle {
                border-bottom: 2px solid #0c5d73;
            }

            &:not(:nth-last-child(2)) .interactiveTableName {
                border-bottom: 2px solid #303036;
            }

            .interactiveTableTitle {
                width: 75px;
                background-color: var(--colorBlueDark);
                color: var(--colorWhite);
                padding: 5px;
                font-weight: bold;
                letter-spacing: 0.05em;
            }

            .interactiveTableName {
                padding: 5px;
                width: 100%;
                background-color: var(--colorBG3);
            }
        }
        .removeStatus{
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            display: flex;
            align-items: center;
            padding-right: 5px;
            color: var(--colorWhite);
            transition: var(--transition);
            opacity: 0;
            &:hover{
                color: var(--colorBlueLight);
                cursor: pointer;
                opacity: 1;
            }
        }
        .addRow {
            border: none !important;
            background-color: rgba(14, 116, 144, .5);
            border-radius: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 5px;
            transition: var(--transition);
            &:hover{
                background-color: var(--colorBlueLight);
                cursor: pointer;
            }
        }
    }
}
</style>
