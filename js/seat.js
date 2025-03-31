document.addEventListener("DOMContentLoaded", function() {
    let selectedSeats = [];
    const pricePerSeat = 3000;
    
    document.querySelectorAll(".seat.available").forEach(seat => {
        seat.addEventListener("click", function() {
            if (!selectedSeats.includes(this.dataset.seat)) {
                selectedSeats.push(this.dataset.seat);
                this.classList.add("selected");
            } else {
                selectedSeats = selectedSeats.filter(seatNum => seatNum !== this.dataset.seat);
                this.classList.remove("selected");
            }
            updateSummary();
        });
    });

    function updateSummary() {
        document.getElementById("selected-seats").innerText = selectedSeats.join(", ");
        document.getElementById("total-price").innerText = selectedSeats.length * pricePerSeat;
    }

    document.getElementById("confirm-booking").addEventListener("click", function() {
        if (selectedSeats.length === 0) {
            alert("Please select at least one seat.");
            return;
        }

        fetch("process_booking.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ seats: selectedSeats, bus_id: 1 })
        }).then(response => response.text())
          .then(data => alert(data))
          .catch(error => console.error(error));
    });
});
