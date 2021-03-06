<?hh // decl

namespace spec\Md\CatHacks\Std\Option;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Md\CatHacks\Laws\MonadLaws;

use Md\CatHacks\Std\Option\OptionMonad;
use Md\CatHacks\Std\Option\OptionFlatmap;
use Md\CatHacks\Std\Option\OptionFunctor;

use Eris\TestTrait;
use Eris\Generator\IntegerGenerator as IntGen;

use Md\PropertyTesting\Generator\RandomContainersGenerator;

class OptionMonadSpec extends ObjectBehavior
{
    use RandomContainersGenerator;
    use TestTrait;
    use MonadLaws;

    public
    function it_is_initializable()
    {
        $this->shouldHaveType(OptionMonad::class);
    }

    public
    function it_is_a_flatmap_and_a_functor()
    {
        $this->shouldHaveType(OptionFlatmap::class);
        $this->shouldHaveType(OptionFunctor::class);
    }

    public
    function it_obeys_the_flatmap_associativity_law()
    {
        $this->forAll(
            $this->genOption(),
            $this->genFunctionIntToFString('Option'),
            $this->genFunctionStringToFInt('Option')
        )->then(($fa, $f, $g) ==>
            expect($this->flapMapAssociativity($fa, $f->get(), $g->get()))->toBe(true)
        );
    }

    public
    function it_obeys_the_flatmap_left_identity_law()
    {
        $this->forAll(
            $this->genOption(),
            new IntGen(),
            $this->genFunctionIntToFString('Option')
        )->then(($fa, $a, $f) ==>
            expect($this->leftIdentity($fa, $a, $f->get()))->toBe(true)
        );
    }

    public
    function it_obeys_the_flatmap_right_identity_law()
    {
        $this->forAll(
            $this->genOption()
        )->then($fa ==>
            expect($this->rightIdentity($fa))->toBe(true)
        );
    }

    public
    function it_implements_flatten()
    {
        $this->forAll(
            new IntGen(),
        )->then($a ==>
            $this->flatten(Some(Some(Some($a))))->shouldBeLike(Some(Some($a)))
        );
    }
}
