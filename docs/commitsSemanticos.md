# Convenção de Commits Semânticos

## Tipos de Commits

- **build:** Alterações que afetam o sistema de construção ou dependências externas.
  - Exemplo: `build(npm): atualizar pacotes para a versão 2.0.0`

- **ci:** Alterações nos arquivos e scripts de configuração de integração contínua (CI).
  - Exemplo: `ci(runner): adicionar runner na etapa de compilação ao pipeline`

- **docs:** Inclusão ou alteração de arquivos de documentação.
  - Exemplo: `docs(readme): corrigir erro ortográfico`

- **feat:** Adições de novas funcionalidades ou implantações ao código.
  - Exemplo: `feat(login): adicionar autenticação por dois fatores`

- **fix:** Correções de bugs.
  - Exemplo: `fix(api): resolver problema de rota não encontrada`

- **perf:** Alterações de código que melhoram o desempenho.
  - Exemplo: `perf(consulta): otimizar consulta ao banco de dados`

- **refactor:** Mudanças no código que não alteram a funcionalidade final.
  - Exemplo: `refactor(rotas): reorganizar código para melhor legibilidade`

- **style:** Alterações na apresentação do código (formatação, espaços em branco).
  - Exemplo: `style(eslint): corrigir indentação no arquivo main.js`

- **test:** Adição ou correção de testes automatizados.
  - Exemplo: `test(unit): adicionar teste para função de ordenação`

- **chore:** Atualizações de tarefas que não afetam o código de produção.
  - Exemplo: `chore(dependências): atualizar versão do Node.js para 14`

- **env:** Modificações em arquivos de configuração de integração contínua (CI) e ambientes.
  - Exemplo: `env(docker): adicionar parâmetros de ambiente ao contêiner`

## Exemplo de Mensagem de Commit

```markdown
feat(carrinho): adicionar funcionalidade de remover item
- Adiciona a capacidade de remover itens do carrinho de compras.
- Inclui botão "Remover" na interface do usuário.

Closes #123
```

Este é um exemplo com um corpo de commit, onde informações adicionais sobre o commit são fornecidas.

O corpo pode conter detalhes sobre as alterações realizadas, a lógica por trás delas e qualquer outra informação relevante. É uma prática útil, especialmente para commits mais complexos ou que exigem uma explicação mais detalhada. Certifique-se de adaptar conforme as necessidades específicas do seu projeto.