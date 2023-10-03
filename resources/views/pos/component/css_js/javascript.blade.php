<script>
    $(document).ready(function() {
        $("#refresh-local-btn").click(function(e) {
            e.preventDefault();
            localStorage.removeItem('room_booking');
            localStorage.removeItem('food_booking');
            localStorage.removeItem('service_booking');
            window.location.href = $(this).attr('href');
        });

        const $dragElement = $(".drag-element");
        let isDragging = false;
        let offsetX, offsetY;

        $dragElement.on("mousedown", startDragging);
        $(document).on("mousemove", moveElement);
        $(document).on("mouseup", stopDragging);

        function startDragging(e) {
            isDragging = true;
            offsetX = e.clientX -  $dragElement.offset().left;
            $dragElement.css("cursor", "grabbing");
        }

        function moveElement(e) {
            if (!isDragging) return;
            const x = e.clientX - offsetX;
            $dragElement.css({ transform: `translateX(${x}px)` });
        }

        function stopDragging() {
            isDragging = false;
            $dragElement.css("cursor", "grab");
        }
    });
</script>