<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $renter_id
 * @property int $vehicle_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property numeric $total_price
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RenterAccount $renter
 * @property-read \App\Models\Review|null $review
 * @property-read \App\Models\Vehicle $vehicle
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereRenterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereVehicleId($value)
 */
	class Booking extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $email
 * @property string $password_hash
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\OwnerProfile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerAccount whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerAccount whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerAccount wherePasswordHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerAccount whereUpdatedAt($value)
 */
	class OwnerAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $owner_id
 * @property string|null $full_name
 * @property string|null $nik
 * @property string|null $ktp_image_url
 * @property string $verification_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\OwnerAccount $owner
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerProfile whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerProfile whereKtpImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerProfile whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerProfile whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OwnerProfile whereVerificationStatus($value)
 */
	class OwnerProfile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $email
 * @property string $password_hash
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read \App\Models\RenterProfile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterAccount whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterAccount whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterAccount wherePasswordHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterAccount whereUpdatedAt($value)
 */
	class RenterAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $renter_id
 * @property string|null $full_name
 * @property string|null $nik
 * @property string|null $license_no
 * @property string|null $sim_image_url
 * @property string $verification_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RenterAccount $renter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile whereLicenseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile whereRenterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile whereSimImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RenterProfile whereVerificationStatus($value)
 */
	class RenterProfile extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $booking_id
 * @property int $rating
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Booking $booking
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereUpdatedAt($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $owner_id
 * @property string $brand
 * @property string $model
 * @property numeric $daily_rate
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read \App\Models\OwnerAccount $owner
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereDailyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereUpdatedAt($value)
 */
	class Vehicle extends \Eloquent {}
}

