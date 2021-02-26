<template>
    <div>
        <label>Feet</label>
        <input id="inputFeet" type="number" placeholder="Feet" oninput="LengthConverter(this.value)" onchange="LengthConverter(this.value)">
        </p>
        <p>Meters: <span id="outputMeters"></span></p>
    </div>
</template>

<script>

    function LengthConverter(valNum) {
        document.getElementById("outputMeters").innerHTML=valNum/3.2808;
    }
</script>
