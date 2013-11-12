<?php
namespace Stasmo\BirchBundle\Entity;

class GetQuote
{
	protected $name;
	protected $emailAddress;
	protected $numberOfGuests;
	protected $phoneNumber;
	protected $eventDate;
	protected $eventStart;
	protected $eventEnd;
	protected $eventType;

	public function getEmailAddress(){
		return $this->emailAddress;
	}

	public function setEmailAddress($emailAddress){
		$this->emailAddress = $emailAddress;
	}

	public function getNumberOfGuests(){
		return $this->numberOfGuests;
	}

	public function setNumberOfGuests($numberOfGuests){
		$this->numberOfGuests = $numberOfGuests;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getPhoneNumber(){
		return $this->phoneNumber;
	}

	public function setPhoneNumber($phoneNumber){
		$this->phoneNumber = $phoneNumber;
	}

	public function getEventDate(){
		return $this->eventDate;
	}

	public function setEventDate($eventDate){
		$this->eventDate = $eventDate;
	}

	public function getEventStart(){
		return $this->eventStart;
	}

	public function setEventStart($eventStart){
		$this->eventStart = $eventStart;
	}

	public function getEventEnd(){
		return $this->eventEnd;
	}

	public function setEventEnd($eventEnd){
		$this->eventEnd = $eventEnd;
	}

	public function getEventType(){
		return $this->eventType;
	}

	public function setEventType($eventType){
		$this->eventType = $eventType;
	}

}