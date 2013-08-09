<?php
	
	Class CronTaskFilterIterator extends FilterIterator{
	
		public function __construct($path){

			if(is_dir($path) == true){
				parent::__construct(new DirectoryIterator($path));
			}else{
				throw new Exception('Directory Missing. Create a manifest/cron directory with 0777 permissions.'); 
			}
			
		}	
	
		public function accept(){
			$current = $this->current();
			return ($current->isDot() || $current->isDir() || substr($current->getFilename(), 0, 1) == '.' ? false : true);
		}	
	}
	
	Final Class CronTaskIterator implements Iterator{
	
		private $_iterator;
	
		public function __construct($directory){
			$this->_iterator = new CronTaskFilterIterator($directory);
		}

		public function current(){
			$this->_current = $this->_iterator->current();
			return new CronTask($this->_current->getPathname());
		}
	
		public function innerIterator(){
			return $this->_iterator;
		}
	
		public function next(){
			$this->_iterator->next();
		}
	
		public function key(){
			return $this->_iterator->key();
		}

		public function valid(){
			return $this->_iterator->valid();
		}
	
		public function rewind(){
			$this->_iterator->rewind();
		}
			
		public function position(){
			throw new Exception('CronTaskIterator::position() cannot be called.'); 
		}

		public function length(){
			throw new Exception('CronTaskIterator::length() cannot be called.');
		}
	
	}