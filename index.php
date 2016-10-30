<?php

class BoothMoney
{
    protected $availableNotes = [ 100, 50, 5, 2 ];

    protected $givenMoney = null;
    protected $defaultMoney = null;

    protected $notes = [];

    protected $immediateNote = null;

    private $result = null;

    public function __construct($givenMoney)
    {
        $this->givenMoney = $givenMoney;
        $this->defaultMoney = $givenMoney;

        $this->process();
    }

    public function setImemdiateNote($money)
    {
        foreach( $this->availableNotes as $note ) {
            if( $note <= $money ) {
                $this->immediateNote = $note;
                break;
            }else{
                $this->unsetNotes($note);
            }
        }
    }

    public function process()
    {
        /* Step-1 */
        $this->setImemdiateNote($this->givenMoney);

        /* Step-2 */
        $this->result = floor($this->givenMoney / $this->immediateNote);

        /* Step-3 */
        $restResult = $this->givenMoney % $this->immediateNote;

        /* Step-4 */
        $this->checkResult($restResult);

    }

    public function checkResult($restResult)
    {
        switch($restResult){
            case 1:
            case 3:
                    $this->notes[$this->immediateNote] = ($this->result - 1);

                    $this->givenMoney -= ($this->result - 1) * $this->immediateNote;
                    $this->unsetNotes($this->immediateNote);

                    if( count($this->availableNotes) > 0){
                        return $this->process();
                    }
                break;

            case 0:
                    $this->notes[$this->immediateNote] = $this->result;
                break;

            default :
                @$this->notes[$this->immediateNote] += 1;
                $this->givenMoney -= $this->immediateNote;
                return $this->process();

        }
    }

    public function unsetNotes($del_val)
    {
        if(($key = array_search($del_val, $this->availableNotes)) !== false) {
            unset($this->availableNotes[$key]);
        }
    }

    public function get()
    {
        return $this->notes;
    }
}

$obj = new BoothMoney(101);

echo '<pre>';
print_r($obj->get());
echo '</pre>';
