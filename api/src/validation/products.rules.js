import { body, param } from 'express-validator';

export const productCreateRules = [

  body('sku')
    .notEmpty().withMessage('El SKU es obligatorio')
    .matches(/^[A-Z0-9-]+$/).withMessage('Formato SKU inválido'),

  body('name')
    .isString().withMessage('El nombre debe ser texto')
    .isLength({ min: 2 }).withMessage('Mínimo 2 caracteres'),

  body('description')
    .isString().withMessage('La descripción debe ser texto')
    .isLength({ min: 5 }).withMessage('Mínimo 5 caracteres'),

  body('price')
    .isFloat({ min: 0 }).withMessage('El precio debe ser >= 0'),

  body('stock')
    .isInt({ min: 0 }).withMessage('El stock debe ser >= 0'),

  body('image')
    .optional()
    .isString().withMessage('La imagen debe ser texto'),

  body('category')
    .notEmpty().withMessage('La categoría es obligatoria')
    .isIn(['pelicula', 'serie', 'documental'])
    .withMessage('Categoría inválida')
];

export const productUpdateRules = [

  param('id')
    .isMongoId().withMessage('ID inválido'),

  body('sku')
    .optional()
    .matches(/^[A-Z0-9-]+$/)
    .withMessage('Formato SKU inválido'),

  body('name')
    .optional()
    .isString()
    .isLength({ min: 2 }),

  body('description')
    .optional()
    .isString()
    .isLength({ min: 5 }),

  body('price')
    .optional()
    .isFloat({ min: 0 }),

  body('stock')
    .optional()
    .isInt({ min: 0 }),

  body('image')
    .optional()
    .isString(),

  body('category')
    .optional()
    .isIn(['pelicula', 'serie', 'documental'])
];