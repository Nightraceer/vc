<?php


namespace TestWork\Controller;


use Atk4\Dsql\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionException;
use TestWork\Connection\DB;
use TestWork\DataManager\AdvertisementManager;
use TestWork\DataManager\Entity\Advertisement;
use TestWork\DataManager\EntityFactory\AdvertisementFactory;
use TestWork\DataManager\Exception\NotFoundException;
use TestWork\Utils\Arr;
use TestWork\Validator\Validator;
use Throwable;

/**
 * Class AdsController
 * @package TestWork\Controller
 */
class AdsController extends BaseController
{
    private AdvertisementFactory $advertisementFactory;
    private AdvertisementManager $advertisementManager;
    private Validator $validator;

    /**
     * AdsController constructor.
     * @param DB $db
     */
    public function __construct(DB $db)
    {
        parent::__construct($db);
        $this->advertisementFactory = new AdvertisementFactory();
        $this->advertisementManager = new AdvertisementManager($this->db, $this->advertisementFactory);
        $this->validator = new Validator($this->db);
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $routerMeta
     * @return ResponseInterface
     * @throws Exception
     */
    public function create(ServerRequestInterface $request, array $routerMeta): ResponseInterface
    {
        $requestFields = $request->getParsedBody();

        $fieldsErrors = [];
        foreach ($this->getAdsFields() as $name => $options) {
            $errors = $this->validator->handle($requestFields[$name] ?? null, $options['constraints']);
            if (!empty($errors)) {
                $fieldsErrors[$name] = $errors;
            }
        }

        if (!empty($fieldsErrors)) {
            return $this->getResponse([
                'message' => 'Validation errors',
                'code' => 400,
                'data' => [
                    'errors' => $fieldsErrors
                ]
            ]);
        }

        $advertisement = $this->advertisementFactory->create($requestFields);
        $advertisement = $this->advertisementManager->create($advertisement);

        return $this->getResponse([
            'message' => 'OK',
            'code' => 200,
            'data' => Arr::exclude($advertisement->toArray(), ['price', 'limit', 'showing', 'updated_at', 'created_at'])
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $routerMeta
     * @return ResponseInterface
     *
     * @throws Exception
     * @throws NotFoundException
     */
    public function edit(ServerRequestInterface $request, array $routerMeta): ResponseInterface
    {
        $advertisement = $this->advertisementManager->findById($routerMeta['id']);

        $requestFields = $request->getParsedBody();

        $fieldsErrors = [];
        foreach ($requestFields as $name => $value) {
            $errors = $this->validator->handle($value ?? null, $this->getAdsFields()[$name]['constraints']);
            if (!empty($errors)) {
                $fieldsErrors[$name] = $errors;
            }
        }
        if (!empty($fieldsErrors)) {
            return $this->getResponse([
                'message' => 'Validation errors',
                'code' => 400,
                'data' => [
                    'errors' => $fieldsErrors
                ]
            ]);
        }

        $advertisement = $this->advertisementFactory->modify($advertisement, $requestFields);
        $this->advertisementManager->update($advertisement);


        return $this->getResponse([
            'message' => 'OK',
            'code' => 200,
            'data' => Arr::exclude($advertisement->toArray(), ['price', 'limit', 'showing', 'updated_at', 'created_at'])
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $routerMeta
     * @return ResponseInterface
     *
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function relevant(ServerRequestInterface $request, array $routerMeta): ResponseInterface
    {
        /** @var Advertisement $advertisement */
        $advertisement = $this->advertisementManager->findRelevant();
        $advertisement->increaseShowing();
        $this->advertisementManager->update($advertisement);

        return $this->getResponse([
            'message' => 'OK',
            'code' => 200,
            'data' => Arr::exclude($advertisement->toArray(), ['price', 'limit', 'showing', 'updated_at', 'created_at'])
        ]);
    }

    /**
     * @return \array[][][]
     */
    private function getAdsFields(): array
    {
        return [
            'text' => [
                'constraints' => [
                    'required' => []
                ]
            ],
            'price' => [
                'constraints' => [
                    'required' => []
                ]
            ],
            'limit' => [
                'constraints' => [
                    'required' => []
                ]
            ],
            'banner' => [
                'constraints' => [
                    'required' => [],
                    'url' => []
                ]
            ]
        ];
    }
}
