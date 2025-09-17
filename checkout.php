<?php
session_start(); // Must be first line

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize user input
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $phone   = htmlspecialchars($_POST['phone']);
    $event   = htmlspecialchars($_POST['event']);
    $venue   = htmlspecialchars($_POST['venue']);
    $request = htmlspecialchars($_POST['request']);

    // Owner email (use your domain email)
    $ownerEmail = "info@arunstudios.com";
    $subjectOwner = "New Booking Request - Arun Studios";

    $messageOwner = "
You have received a new booking request:

Name: $name
Email: $email
Contact Number: $phone
Event Name: $event
Event Venue: $venue
Special Request: $request
";

    $headersOwner  = "From: $ownerEmail\r\n";
    $headersOwner .= "Reply-To: $email\r\n";

    // Customer confirmation email
    $subjectCustomer = "Booking Confirmation - Arun Studios";
    $messageCustomer = "
Dear $name,

Thank you for booking with Arun Studios! We have received your request:

Event Name: $event
Event Venue: $venue

Our team will contact you shortly to confirm the details.

Regards,
Arun Studios
";

    $headersCustomer  = "From: $ownerEmail\r\n";
    $headersCustomer .= "Reply-To: $ownerEmail\r\n";

    // Send emails
    $mailOwner    = mail($ownerEmail, $subjectOwner, $messageOwner, $headersOwner);
    $mailCustomer = mail($email, $subjectCustomer, $messageCustomer, $headersCustomer);

    // Set flash message
    if ($mailOwner && $mailCustomer) {
        $_SESSION['flash'] = ['type'=>'success','message'=>'Thank you! Your booking request has been received.'];
    } else {
        $_SESSION['flash'] = ['type'=>'error','message'=>'Oops! Something went wrong. Please try again.'];
    }

    // Redirect to avoid form resubmission
    header("Location: checkout.php");
    exit();
}

include 'header.php';
?>

<!-- Contact Section -->
<div class="container" style="margin-top:100px;">
    <h1 class="text-center mb-4">Contact Us</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Booking Form -->
           <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="number" name="phone" class="form-control" placeholder="Enter your phone number" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Event Name</label>
                    <input type="text" name="event" class="form-control" placeholder="Enter your Event name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Event Venue</label>
                    <input type="text" name="venue" class="form-control" placeholder="Enter your Event Venue" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Any special request</label>
                    <textarea name="request" class="form-control" rows="5" placeholder="Write your message"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Book Now</button>
            </form>
        </div>
    </div>
</div>

<!-- Success / Error Modal -->
<?php if (isset($_SESSION['flash'])): ?>
<div class="modal fade" id="flashModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header <?php echo ($_SESSION['flash']['type']=='success')?'bg-success':'bg-danger'; ?> text-white">
        <h5 class="modal-title">
            <?php echo ($_SESSION['flash']['type']=='success') ? 'Booking Successful' : 'Error'; ?>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><?php echo $_SESSION['flash']['message']; ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn <?php echo ($_SESSION['flash']['type']=='success')?'btn-success':'btn-danger'; ?>" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<?php unset($_SESSION['flash']); endif; ?>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if (isset($_SESSION['flash'])): ?>
<script>
    var myModal = new bootstrap.Modal(document.getElementById('flashModal'));
    myModal.show();
</script>
<?php endif; ?>
