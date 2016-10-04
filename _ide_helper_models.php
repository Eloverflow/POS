<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\ERP{
/**
 * App\Models\ERP\Supplier
 *
 * @property integer $id
 * @property string $name
 * @property string $civic_number
 * @property string $address
 * @property string $address_type
 * @property string $postal
 * @property string $city
 * @property string $region/state
 * @property string $country
 * @property string $address2
 * @property string $tips
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereCivicNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereAddressType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier wherePostal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereRegion/state($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereAddress2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereTips($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Supplier whereUpdatedAt($value)
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models\ERP{
/**
 * App\Models\ERP\Inventory
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $quantity
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ERP\Item $item
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Inventory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Inventory whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Inventory whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Inventory whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Inventory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Inventory whereUpdatedAt($value)
 */
	class Inventory extends \Eloquent {}
}

namespace App\Models\ERP{
/**
 * App\Models\ERP\ExtraItem
 *
 * @property integer $id
 * @property integer $extra_id
 * @property integer $item_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ERP\Extra $extra
 * @property-read \App\Models\ERP\Item $item
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\ExtraItem whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\ExtraItem whereExtraId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\ExtraItem whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\ExtraItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\ExtraItem whereUpdatedAt($value)
 */
	class ExtraItem extends \Eloquent {}
}

namespace App\Models\ERP{
/**
 * App\Models\ERP\Extra
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $effect
 * @property float $value
 * @property integer $status
 * @property boolean $avail_for_command
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ERP\ExtraItem[] $extra_item
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ERP\ExtraItemType[] $extra_item_type
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Extra whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Extra whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Extra whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Extra whereEffect($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Extra whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Extra whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Extra whereAvailForCommand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Extra whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Extra whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Extra whereUpdatedAt($value)
 */
	class Extra extends \Eloquent {}
}

namespace App\Models\ERP{
/**
 * App\Models\ERP\Item
 *
 * @property integer $id
 * @property integer $item_type_id
 * @property string $img_id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property string $custom_fields_array
 * @property string $size_prices_array
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ERP\ItemType $itemtype
 * @property-read \App\Models\ERP\Inventory $inventory
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ERP\ExtraItem[] $extra_item
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Item whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Item whereItemTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Item whereImgId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Item whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Item whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Item whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Item whereCustomFieldsArray($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Item whereSizePricesArray($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Item whereUpdatedAt($value)
 */
	class Item extends \Eloquent {}
}

namespace App\Models\ERP{
/**
 * App\Models\ERP\OrderLine
 *
 * @property integer $id
 * @property integer $quantity
 * @property integer $order_id
 * @property integer $item_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\OrderLine whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\OrderLine whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\OrderLine whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\OrderLine whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\OrderLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\OrderLine whereUpdatedAt($value)
 */
	class OrderLine extends \Eloquent {}
}

namespace App\Models\ERP{
/**
 * App\Models\ERP\Contact
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $cellphone
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Contact whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Contact whereSupplierId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Contact whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Contact whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Contact wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Contact whereCellphone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Contact whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Contact whereUpdatedAt($value)
 */
	class Contact extends \Eloquent {}
}

namespace App\Models\ERP{
/**
 * App\Models\ERP\ExtraItemType
 *
 * @property integer $id
 * @property integer $extra_id
 * @property integer $item_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ERP\Extra $extra
 * @property-read \App\Models\ERP\ItemType $itemtype
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\ExtraItemType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\ExtraItemType whereExtraId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\ExtraItemType whereItemTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\ExtraItemType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\ExtraItemType whereUpdatedAt($value)
 */
	class ExtraItemType extends \Eloquent {}
}

namespace App\Models\ERP{
/**
 * App\Models\ERP\Order
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property string $command_number
 * @property string $invoice_number
 * @property string $po_number
 * @property string $delivery_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Order whereSupplierId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Order whereCommandNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Order whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Order wherePoNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Order whereDeliveryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ERP\Order whereUpdatedAt($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models\Auth{
/**
 * App\Models\Auth\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models\Addons\Rfid{
/**
 * App\Models\Addons\Rfid\TableRfidRequest
 *
 * @property integer $id
 * @property string $flash_card_hw_code
 * @property string $rfid_card_code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfidRequest whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfidRequest whereFlashCardHwCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfidRequest whereRfidCardCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfidRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfidRequest whereUpdatedAt($value)
 */
	class TableRfidRequest extends \Eloquent {}
}

namespace App\Models\Addons\Rfid{
/**
 * App\Models\Addons\Rfid\TableRfid
 *
 * @property integer $id
 * @property string $flash_card_hw_code
 * @property string $phone_hw_code
 * @property string $beer1_item_id
 * @property string $beer2_item_id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\ERP\Item $beer1
 * @property-read \App\Models\ERP\Item $beer2
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfid whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfid whereFlashCardHwCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfid wherePhoneHwCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfid whereBeer1ItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfid whereBeer2ItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfid whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfid whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfid whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfid whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Addons\Rfid\TableRfid whereUpdatedAt($value)
 */
	class TableRfid extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Day_Availability
 *
 * @property integer $id
 * @property integer $availability_id
 * @property integer $day_number
 * @property string $startTime
 * @property string $endTime
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Availability whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Availability whereAvailabilityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Availability whereDayNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Availability whereStartTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Availability whereEndTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Availability whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Availability whereUpdatedAt($value)
 */
	class Day_Availability extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Availability
 *
 * @property integer $id
 * @property integer $employee_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Availability whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Availability whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Availability whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Availability whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Availability whereUpdatedAt($value)
 */
	class Availability extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Separation
 *
 * @property integer $id
 * @property integer $noFloor
 * @property integer $xPos
 * @property integer $yPos
 * @property integer $w
 * @property integer $h
 * @property string $angle
 * @property integer $plan_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\POS\Plan $plan
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Separation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Separation whereNoFloor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Separation whereXPos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Separation whereYPos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Separation whereW($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Separation whereH($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Separation whereAngle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Separation wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Separation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Separation whereUpdatedAt($value)
 */
	class Separation extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Day_Schedules
 *
 * @property integer $id
 * @property integer $schedule_id
 * @property integer $employee_id
 * @property string $startTime
 * @property string $endTime
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Schedules whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Schedules whereScheduleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Schedules whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Schedules whereStartTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Schedules whereEndTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Schedules whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Day_Schedules whereUpdatedAt($value)
 */
	class Day_Schedules extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\FilterItem
 *
 * @property integer $id
 * @property integer $filter_id
 * @property integer $item_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\POS\Filter $filter
 * @property-read \App\Models\ERP\Item $item
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\FilterItem whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\FilterItem whereFilterId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\FilterItem whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\FilterItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\FilterItem whereUpdatedAt($value)
 */
	class FilterItem extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Plan
 *
 * @property integer $id
 * @property string $name
 * @property integer $nbFloor
 * @property string $wallPoints
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\POS\Table[] $table
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\POS\Separation[] $separation
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Plan whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Plan whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Plan whereNbFloor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Plan whereWallPoints($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Plan whereUpdatedAt($value)
 */
	class Plan extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Filter
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $importance
 * @property float $type
 * @property integer $status
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\POS\FilterItem[] $filter_item
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\POS\FilterItemType[] $filter_item_type
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Filter whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Filter whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Filter whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Filter whereImportance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Filter whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Filter whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Filter whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Filter whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Filter whereUpdatedAt($value)
 */
	class Filter extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Title_Employees
 *
 * @property integer $id
 * @property integer $employee_id
 * @property integer $work_titles_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Title_Employees whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Title_Employees whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Title_Employees whereWorkTitlesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Title_Employees whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Title_Employees whereUpdatedAt($value)
 */
	class Title_Employees extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Client
 *
 * @property integer $id
 * @property integer $client_number
 * @property integer $credit
 * @property string $rfid_card_code
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Client whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Client whereClientNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Client whereCredit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Client whereRfidCardCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Client whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Client whereUpdatedAt($value)
 */
	class Client extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\FilterItemType
 *
 * @property integer $id
 * @property integer $filter_id
 * @property integer $item_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\POS\Filter $filter
 * @property-read \App\Models\ERP\ItemType $itemtype
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\FilterItemType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\FilterItemType whereFilterId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\FilterItemType whereItemTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\FilterItemType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\FilterItemType whereUpdatedAt($value)
 */
	class FilterItemType extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Schedule
 *
 * @property integer $id
 * @property string $name
 * @property string $startDate
 * @property string $endDate
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Schedule whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Schedule whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Schedule whereStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Schedule whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Schedule whereUpdatedAt($value)
 */
	class Schedule extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Punch
 *
 * @property integer $id
 * @property string $startTime
 * @property string $endTime
 * @property integer $work_title_id
 * @property integer $employee_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Punch whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Punch whereStartTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Punch whereEndTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Punch whereWorkTitleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Punch whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Punch whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Punch whereUpdatedAt($value)
 */
	class Punch extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Employee
 *
 * @property integer $id
 * @property string $firstName
 * @property string $lastName
 * @property string $streetAddress
 * @property string $phone
 * @property string $city
 * @property string $state
 * @property string $pc
 * @property string $nas
 * @property integer $userId
 * @property float $bonusSalary
 * @property string $birthDate
 * @property string $hireDate
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Auth\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereStreetAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee wherePc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereNas($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereBonusSalary($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereBirthDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereHireDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Employee whereUpdatedAt($value)
 */
	class Employee extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\Table
 *
 * @property integer $id
 * @property string $type
 * @property integer $tblNumber
 * @property integer $noFloor
 * @property integer $xPos
 * @property integer $yPos
 * @property string $angle
 * @property integer $plan_id
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\POS\Command[] $command
 * @property-read \App\Models\POS\Plan $plan
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Table whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Table whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Table whereTblNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Table whereNoFloor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Table whereXPos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Table whereYPos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Table whereAngle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Table wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Table whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Table whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\Table whereUpdatedAt($value)
 */
	class Table extends \Eloquent {}
}

namespace App{
/**
 * App\CalendarEvent
 *
 * @property integer $id
 * @property string $name
 * @property boolean $isAllDay
 * @property string $type
 * @property string $startTime
 * @property string $endTime
 * @property integer $moment_type_id
 * @property integer $employee_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarEvent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarEvent whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarEvent whereIsAllDay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarEvent whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarEvent whereStartTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarEvent whereEndTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarEvent whereMomentTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarEvent whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CalendarEvent whereUpdatedAt($value)
 */
	class CalendarEvent extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\MomentType
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\MomentType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\MomentType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\MomentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\MomentType whereUpdatedAt($value)
 */
	class MomentType extends \Eloquent {}
}

namespace App\Models\POS{
/**
 * App\Models\POS\WorkTitle
 *
 * @property integer $id
 * @property string $name
 * @property float $baseSalary
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\WorkTitle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\WorkTitle whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\WorkTitle whereBaseSalary($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\WorkTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\POS\WorkTitle whereUpdatedAt($value)
 */
	class WorkTitle extends \Eloquent {}
}

