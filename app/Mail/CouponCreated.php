<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CouponCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $coupon;

    /**
     * Create a new message instance.
     */
    public function __construct($coupon)
    {
        $this->coupon = $coupon;
    }

    public function build()
    {
        return $this->subject('كوبون اشتراكك في دورات Berna Violin')
            ->view('emails.coupon');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Coupon Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
